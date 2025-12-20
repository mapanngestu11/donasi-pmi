<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;

class LaporanDonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw = $request->get('draw');
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $searchValue = $request->get('search');
            $search = isset($searchValue['value']) ? $searchValue['value'] : '';

            $query = Donasi::query();

            // Filter by status
            $statusFilter = $request->get('status_filter');
            if (!empty($statusFilter)) {
                if ($statusFilter == 'settlement') {
                    $query->where('transaction_status', 'settlement');
                } elseif ($statusFilter == 'pending') {
                    $query->where('transaction_status', 'pending');
                }
            }

            // Search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('telepon', 'like', '%' . $search . '%')
                      ->orWhere('pesan', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = Donasi::count();
            $filteredRecords = $query->count();

            $donasi = $query->orderBy('created_at', 'desc')
                ->skip($start)
                ->take($length)
                ->get();

            $data = [];
            foreach ($donasi as $index => $row) {
                $noHp = !empty($row->no_hp) ? $row->no_hp : (!empty($row->telepon) ? $row->telepon : '-');
                $nominal = !empty($row->nominal) ? $row->nominal : (!empty($row->jumlah) ? $row->jumlah : 0);
                $keteranganPesan = !empty($row->keterangan_pesan) ? $row->keterangan_pesan : (!empty($row->pesan) ? $row->pesan : '-');
                $bank = $row->bank_display; // Menggunakan accessor untuk format yang lebih baik
                $status = !empty($row->transaction_status) ? $row->transaction_status : 'pending';
                
                $badge = 'info';
                $statusText = ucfirst($status);
                if ($status == 'settlement') {
                    $badge = 'info'; // Blue badge for Success
                    $statusText = 'Success';
                } elseif ($status == 'pending') {
                    $badge = 'warning'; // Yellow badge for Pending
                    $statusText = 'Pending';
                } elseif ($status == 'expire') {
                    $badge = 'danger';
                    $statusText = 'Expired';
                } elseif ($status == 'cancel') {
                    $badge = 'secondary';
                    $statusText = 'Cancelled';
                }
                
                $statusBadge = '<span class="badge badge-' . $badge . '">' . $statusText . '</span>';
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                
                $aksi = '<button onclick="showDetail(' . $row->id . ')" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></button> ' .
                       '<button onclick="deleteDonasi(' . $row->id . ')" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                
                $data[] = [
                    'DT_RowIndex' => $start + $index + 1,
                    'id' => $row->id,
                    'nama' => $row->nama,
                    'no_hp' => $noHp,
                    'email' => $row->email,
                    'nominal' => 'Rp ' . number_format($nominal, 0, ',', '.'),
                    'keterangan_pesan' => strlen($keteranganPesan) > 50 ? substr($keteranganPesan, 0, 50) . '...' : $keteranganPesan,
                    'bank' => $bank,
                    'status' => $statusBadge,
                    'tanggal' => $tanggal,
                    'aksi' => $aksi,
                ];
            }

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        return view('admin.donasi.laporan');
    }

    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        $query = Donasi::query();

        // Filter by status if provided
        $statusFilter = $request->get('status');
        if (!empty($statusFilter)) {
            if ($statusFilter == 'settlement') {
                $query->where('transaction_status', 'settlement');
            } elseif ($statusFilter == 'pending') {
                $query->where('transaction_status', 'pending');
            }
        }

        $donasi = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Laporan_Donasi_' . date('Ymd_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        echo "\xEF\xBB\xBF"; // UTF-8 BOM for Excel

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr style="background-color: #4e73df; color: white;">';
        echo '<th style="padding: 8px; font-weight: bold;">No</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Nama</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Email</th>';
        echo '<th style="padding: 8px; font-weight: bold;">No. HP</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Nominal</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Program</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Status</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Bank/Payment</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Tanggal</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Keterangan</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $no = 1;
        foreach ($donasi as $row) {
            $noHp = !empty($row->no_hp) ? $row->no_hp : (!empty($row->telepon) ? $row->telepon : '-');
            $nominal = !empty($row->nominal) ? $row->nominal : (!empty($row->jumlah) ? $row->jumlah : 0);
            $keteranganPesan = !empty($row->keterangan_pesan) ? $row->keterangan_pesan : (!empty($row->pesan) ? $row->pesan : '-');
            $bank = !empty($row->bank) ? $row->bank : (!empty($row->payment_type) ? $row->payment_type : '-');
            $status = !empty($row->transaction_status) ? ucfirst($row->transaction_status) : 'Pending';
            $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
            $program = !empty($row->program) ? $row->program : '-';

            echo '<tr>';
            echo '<td style="padding: 5px;">' . $no . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row->nama) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row->email) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($noHp) . '</td>';
            echo '<td style="padding: 5px;">Rp ' . number_format($nominal, 0, ',', '.') . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($program) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($status) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($bank) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($tanggal) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($keteranganPesan) . '</td>';
            echo '</tr>';
            $no++;
        }

        echo '</tbody>';
        echo '</table>';
        exit;
    }

    /**
     * Get detail donasi for modal
     */
    public function show($id)
    {
        $donasi = Donasi::findOrFail($id);
        
        $noHp = !empty($donasi->no_hp) ? $donasi->no_hp : (!empty($donasi->telepon) ? $donasi->telepon : '-');
        $nominal = !empty($donasi->nominal) ? $donasi->nominal : (!empty($donasi->jumlah) ? $donasi->jumlah : 0);
        $keteranganPesan = !empty($donasi->keterangan_pesan) ? $donasi->keterangan_pesan : (!empty($donasi->pesan) ? $donasi->pesan : '-');
        $bank = $donasi->bank_display; // Menggunakan accessor untuk format yang lebih baik
        
        $status = !empty($donasi->transaction_status) ? $donasi->transaction_status : 'pending';
        $orderId = !empty($donasi->order_id) ? $donasi->order_id : '-';
        $transactionId = !empty($donasi->transaction_id) ? $donasi->transaction_id : '-';
        $program = !empty($donasi->program) ? $donasi->program : '-';
        $transactionTime = $donasi->transaction_time ? $donasi->transaction_time->format('d/m/Y H:i') : '-';
        $settlementTime = $donasi->settlement_time ? $donasi->settlement_time->format('d/m/Y H:i') : '-';
        $tanggal = $donasi->created_at ? $donasi->created_at->format('d/m/Y H:i') : '-';
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $donasi->id,
                'nama' => $donasi->nama,
                'no_hp' => $noHp,
                'email' => $donasi->email,
                'nominal' => 'Rp ' . number_format($nominal, 0, ',', '.'),
                'keterangan_pesan' => $keteranganPesan,
                'bank' => $bank,
                'status' => $status,
                'tanggal' => $tanggal,
                'order_id' => $orderId,
                'transaction_id' => $transactionId,
                'program' => $program,
                'transaction_time' => $transactionTime,
                'settlement_time' => $settlementTime,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $donasi = Donasi::findOrFail($id);
            $donasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data donasi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data donasi.'
            ], 500);
        }
    }
}

