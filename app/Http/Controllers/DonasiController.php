<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DonasiController extends Controller
{
    private $serverKey;
    private $isProduction;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production', false);
    }

    /**
     * Show donation form
     */
    public function create(Request $request)
    {
        $jumlah = $request->get('jumlah', 25000);

        return view('frontend.donasi.create', compact('jumlah'));
    }

    /**
     * Process donation and create Midtrans transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'jumlah' => 'required|numeric|min:10000',
            'pesan' => 'nullable|string',
        ]);

        // Generate unique order ID
        $orderId = 'DONASI-' . date('Ymd') . '-' . Str::random(8);

        // Create donation record
        $donasi = Donasi::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'program' => 'Umum', // Default program
            'jumlah' => $request->jumlah,
            'pesan' => $request->pesan,
            'order_id' => $orderId,
            'transaction_status' => 'pending',
            'status_code' => '201', // 201 = pending, 200 = settlement, 202 = cancel/expire
        ]);

        // Prepare Midtrans transaction
        $transaction = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->jumlah,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'email' => $request->email,
                'phone' => $request->telepon ? $request->telepon : '',
            ],
            'item_details' => [
                [
                    'id' => 'DONASI-UMUM',
                    'price' => (int) $request->jumlah,
                    'quantity' => 1,
                    'name' => 'Donasi Umum',
                ],
            ],
        ];

        // Create Snap token
        $snapTokenResult = $this->getSnapToken($transaction);

        if (!$snapTokenResult['success']) {
            $errorMsg = isset($snapTokenResult['error']) ? $snapTokenResult['error'] : 'Unknown error';
            Log::error('Failed to get Snap Token', [
                'order_id' => $orderId,
                'server_key' => $this->serverKey ? 'Set' : 'Not Set',
                'is_production' => $this->isProduction,
                'error' => $errorMsg,
            ]);
            
            $errorMessage = isset($snapTokenResult['error']) ? $snapTokenResult['error'] : 'Gagal membuat transaksi. Silakan coba lagi atau hubungi administrator.';
            return back()->withInput()->with('error', $errorMessage);
        }
        
        $snapToken = $snapTokenResult['token'];

        return view('frontend.donasi.payment', [
            'donasi' => $donasi,
            'snapToken' => $snapToken,
        ]);
    }

    /**
     * Get Snap token from Midtrans
     */
    private function getSnapToken(array $transaction)
    {
        try {
            // Check if server key is set
            if (empty($this->serverKey)) {
                Log::error('Midtrans Server Key is not set');
                return [
                    'success' => false,
                    'error' => 'Server Key Midtrans tidak dikonfigurasi. Silakan hubungi administrator.'
                ];
            }

            $baseUrl = $this->isProduction 
                ? 'https://app.midtrans.com' 
                : 'https://app.sandbox.midtrans.com';

            $url = $baseUrl . '/snap/v1/transactions';
            
            Log::info('Requesting Snap Token', [
                'url' => $url,
                'order_id' => $transaction['transaction_details']['order_id'],
                'server_key_set' => !empty($this->serverKey),
            ]);

            $response = Http::timeout(30)
                ->withOptions([
                    'verify' => false, // Disable SSL verification for development
                ])
                ->withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $transaction);

            if ($response->successful()) {
                $responseData = $response->json();
                $token = isset($responseData['token']) ? $responseData['token'] : null;
                
                if ($token) {
                    Log::info('Snap Token generated successfully', [
                        'order_id' => $transaction['transaction_details']['order_id'],
                    ]);
                    return [
                        'success' => true,
                        'token' => $token
                    ];
                } else {
                    Log::error('Snap Token not found in response', [
                        'response' => $responseData,
                    ]);
                    return [
                        'success' => false,
                        'error' => 'Token tidak ditemukan dalam response Midtrans.'
                    ];
                }
            }

            $errorBody = $response->json();
            $errorMessage = 'Gagal membuat transaksi Midtrans.';
            
            if (isset($errorBody['error_messages'])) {
                if (is_array($errorBody['error_messages'])) {
                    $errorMessage = implode(', ', $errorBody['error_messages']);
                } else {
                    $errorMessage = $errorBody['error_messages'];
                }
            } elseif (isset($errorBody['message'])) {
                $errorMessage = $errorBody['message'];
            }

            Log::error('Midtrans Snap Token Error', [
                'response' => $response->body(),
                'status' => $response->status(),
                'error_message' => $errorMessage,
            ]);

            return [
                'success' => false,
                'error' => $errorMessage
            ];
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Midtrans Connection Exception', [
                'message' => $e->getMessage(),
            ]);
            return [
                'success' => false,
                'error' => 'Gagal terhubung ke server Midtrans. Silakan cek koneksi internet Anda.'
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Handle Midtrans notification (webhook)
     */
    public function notification(Request $request)
    {
        try {
            $orderId = $request->order_id;
            $donasi = Donasi::where('order_id', $orderId)->first();

            if (!$donasi) {
                return response()->json(['message' => 'Donasi not found'], 404);
            }

            // Verify transaction status from Midtrans
            $status = $this->getTransactionStatus($orderId);

            if ($status) {
                // Get bank from va_numbers or payment_type
                $bank = null;
                if (isset($status['va_numbers']) && is_array($status['va_numbers']) && count($status['va_numbers']) > 0) {
                    $bank = isset($status['va_numbers'][0]['bank']) ? $status['va_numbers'][0]['bank'] : null;
                } elseif (isset($status['permata_va_number'])) {
                    $bank = 'permata';
                } elseif (isset($status['payment_type'])) {
                    $paymentType = $status['payment_type'];
                    // Extract bank from payment_type (e.g., "bank_transfer" -> "bank_transfer", "bca_va" -> "bca")
                    if (strpos($paymentType, '_va') !== false) {
                        $bank = strtoupper(str_replace('_va', '', $paymentType));
                    } elseif (strpos($paymentType, 'bank_transfer') !== false) {
                        $bank = 'Bank Transfer';
                    } elseif (strpos($paymentType, 'echannel') !== false) {
                        $bank = 'Mandiri';
                    } elseif (strpos($paymentType, 'credit_card') !== false) {
                        $bank = 'Credit Card';
                    } else {
                        $bank = ucfirst(str_replace('_', ' ', $paymentType));
                    }
                }

                // Get status_code and transaction_status
                $statusCode = isset($status['status_code']) ? (string)$status['status_code'] : null;
                $transactionStatus = isset($status['transaction_status']) ? $status['transaction_status'] : 'pending';
                
                // Ensure status_code and transaction_status are synchronized
                // Midtrans status_code: 200 = settlement, 201 = pending, 202 = cancel/expire
                if ($statusCode === null) {
                    // Map transaction_status to status_code if status_code is missing
                    switch($transactionStatus) {
                        case 'settlement':
                            $statusCode = '200';
                            break;
                        case 'pending':
                            $statusCode = '201';
                            break;
                        case 'cancel':
                        case 'expire':
                        case 'deny':
                            $statusCode = '202';
                            break;
                        default:
                            $statusCode = '201'; // Default to pending
                    }
                } else {
                    // Map status_code to transaction_status if transaction_status doesn't match
                    if ($statusCode == '200' && $transactionStatus != 'settlement') {
                        $transactionStatus = 'settlement';
                    } elseif ($statusCode == '201' && $transactionStatus != 'pending') {
                        $transactionStatus = 'pending';
                    } elseif ($statusCode == '202' && !in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
                        // Check fraud_status or other indicators
                        if (isset($status['fraud_status']) && $status['fraud_status'] == 'deny') {
                            $transactionStatus = 'deny';
                        } elseif (isset($status['expiry_time']) && strtotime($status['expiry_time']) < time()) {
                            $transactionStatus = 'expire';
                        } else {
                            $transactionStatus = 'cancel';
                        }
                    }
                }

                $donasi->update([
                    'transaction_id' => isset($status['transaction_id']) ? $status['transaction_id'] : null,
                    'payment_type' => isset($status['payment_type']) ? $status['payment_type'] : null,
                    'bank' => $bank,
                    'transaction_status' => $transactionStatus,
                    'transaction_time' => isset($status['transaction_time']) 
                        ? date('Y-m-d H:i:s', strtotime($status['transaction_time'])) 
                        : null,
                    'settlement_time' => isset($status['settlement_time']) 
                        ? date('Y-m-d H:i:s', strtotime($status['settlement_time'])) 
                        : null,
                    'status_code' => $statusCode,
                    'gross_amount' => isset($status['gross_amount']) ? $status['gross_amount'] : $donasi->jumlah,
                    'fraud_status' => isset($status['fraud_status']) ? $status['fraud_status'] : null,
                ]);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * Get transaction status from Midtrans
     */
    private function getTransactionStatus($orderId)
    {
        try {
            $baseUrl = $this->isProduction 
                ? 'https://api.midtrans.com' 
                : 'https://api.sandbox.midtrans.com';

            $response = Http::withOptions([
                    'verify' => false, // Disable SSL verification for development
                ])
                ->withBasicAuth($this->serverKey, '')
                ->get($baseUrl . '/v2/' . $orderId . '/status');

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Midtrans Status Check Error', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Show payment status page
     */
    public function status($orderId)
    {
        $donasi = Donasi::where('order_id', $orderId)->firstOrFail();

        return view('frontend.donasi.status', compact('donasi'));
    }

    /**
     * Handle payment finish redirect
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        
        // Update transaction status from Midtrans
        $donasi = Donasi::where('order_id', $orderId)->first();
        if ($donasi) {
            $status = $this->getTransactionStatus($orderId);
            if ($status) {
                $this->updateDonasiFromStatus($donasi, $status);
            }
        }
        
        return redirect()->route('donasi.status', $orderId);
    }

    /**
     * Handle payment unfinish redirect
     */
    public function unfinish(Request $request)
    {
        $orderId = $request->order_id;
        
        // Update transaction status from Midtrans
        $donasi = Donasi::where('order_id', $orderId)->first();
        if ($donasi) {
            $status = $this->getTransactionStatus($orderId);
            if ($status) {
                $this->updateDonasiFromStatus($donasi, $status);
            }
        }
        
        return redirect()->route('donasi.status', $orderId)
            ->with('warning', 'Pembayaran belum selesai. Silakan selesaikan pembayaran Anda.');
    }

    /**
     * Handle payment error redirect
     */
    public function error(Request $request)
    {
        $orderId = $request->order_id;
        
        // Update transaction status from Midtrans
        $donasi = Donasi::where('order_id', $orderId)->first();
        if ($donasi) {
            $status = $this->getTransactionStatus($orderId);
            if ($status) {
                $this->updateDonasiFromStatus($donasi, $status);
            }
        }
        
        return redirect()->route('donasi.status', $orderId)
            ->with('error', 'Terjadi kesalahan saat proses pembayaran. Silakan coba lagi.');
    }

    /**
     * Update donasi from Midtrans status (helper method)
     */
    private function updateDonasiFromStatus($donasi, $status)
    {
        // Get bank from va_numbers or payment_type
        $bank = null;
        if (isset($status['va_numbers']) && is_array($status['va_numbers']) && count($status['va_numbers']) > 0) {
            $bank = isset($status['va_numbers'][0]['bank']) ? $status['va_numbers'][0]['bank'] : null;
        } elseif (isset($status['permata_va_number'])) {
            $bank = 'permata';
        } elseif (isset($status['payment_type'])) {
            $paymentType = $status['payment_type'];
            // Extract bank from payment_type
            if (strpos($paymentType, '_va') !== false) {
                $bank = strtoupper(str_replace('_va', '', $paymentType));
            } elseif (strpos($paymentType, 'bank_transfer') !== false) {
                $bank = 'Bank Transfer';
            } elseif (strpos($paymentType, 'echannel') !== false) {
                $bank = 'Mandiri';
            } elseif (strpos($paymentType, 'credit_card') !== false) {
                $bank = 'Credit Card';
            } else {
                $bank = ucfirst(str_replace('_', ' ', $paymentType));
            }
        }

        // Get status_code and transaction_status
        $statusCode = isset($status['status_code']) ? (string)$status['status_code'] : null;
        $transactionStatus = isset($status['transaction_status']) ? $status['transaction_status'] : 'pending';
        
        // Ensure status_code and transaction_status are synchronized
        // Midtrans status_code: 200 = settlement, 201 = pending, 202 = cancel/expire
        if ($statusCode === null) {
            // Map transaction_status to status_code if status_code is missing
            switch($transactionStatus) {
                case 'settlement':
                    $statusCode = '200';
                    break;
                case 'pending':
                    $statusCode = '201';
                    break;
                case 'cancel':
                case 'expire':
                case 'deny':
                    $statusCode = '202';
                    break;
                default:
                    $statusCode = '201'; // Default to pending
            }
        } else {
            // Map status_code to transaction_status if transaction_status doesn't match
            if ($statusCode == '200' && $transactionStatus != 'settlement') {
                $transactionStatus = 'settlement';
            } elseif ($statusCode == '201' && $transactionStatus != 'pending') {
                $transactionStatus = 'pending';
            } elseif ($statusCode == '202' && !in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
                // Check fraud_status or other indicators
                if (isset($status['fraud_status']) && $status['fraud_status'] == 'deny') {
                    $transactionStatus = 'deny';
                } elseif (isset($status['expiry_time']) && strtotime($status['expiry_time']) < time()) {
                    $transactionStatus = 'expire';
                } else {
                    $transactionStatus = 'cancel';
                }
            }
        }

        $donasi->update([
            'transaction_id' => isset($status['transaction_id']) ? $status['transaction_id'] : null,
            'payment_type' => isset($status['payment_type']) ? $status['payment_type'] : null,
            'bank' => $bank,
            'transaction_status' => $transactionStatus,
            'transaction_time' => isset($status['transaction_time']) 
                ? date('Y-m-d H:i:s', strtotime($status['transaction_time'])) 
                : null,
            'settlement_time' => isset($status['settlement_time']) 
                ? date('Y-m-d H:i:s', strtotime($status['settlement_time'])) 
                : null,
            'status_code' => $statusCode,
            'gross_amount' => isset($status['gross_amount']) ? $status['gross_amount'] : $donasi->jumlah,
            'fraud_status' => isset($status['fraud_status']) ? $status['fraud_status'] : null,
        ]);
    }
}

