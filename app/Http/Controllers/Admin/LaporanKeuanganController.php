<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganController extends Controller
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
            $typeFilter = $request->get('type_filter', ''); // 'pendapatan' or 'pengeluaran' or ''

            $data = [];
            $totalRecords = 0;
            $filteredRecords = 0;

            // Get Pendapatan (Donasi with settlement status)
            if (empty($typeFilter) || $typeFilter == 'pendapatan') {
                $pendapatanQuery = Donasi::where('transaction_status', 'settlement');

                if (!empty($search)) {
                    $pendapatanQuery->where(function($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%')
                          ->orWhere('telepon', 'like', '%' . $search . '%')
                          ->orWhere('no_hp', 'like', '%' . $search . '%')
                          ->orWhere('pesan', 'like', '%' . $search . '%')
                          ->orWhere('keterangan_pesan', 'like', '%' . $search . '%');
                    });
                }

                $pendapatan = $pendapatanQuery->orderBy('created_at', 'desc')->get();

                foreach ($pendapatan as $row) {
                    $noHp = !empty($row->no_hp) ? $row->no_hp : (!empty($row->telepon) ? $row->telepon : '-');
                    $nominal = !empty($row->nominal) ? $row->nominal : (!empty($row->jumlah) ? $row->jumlah : 0);
                    $keteranganPesan = !empty($row->keterangan_pesan) ? $row->keterangan_pesan : (!empty($row->pesan) ? $row->pesan : '-');
                    $bank = $row->bank_display;
                    $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';

                    $data[] = [
                        'DT_RowIndex' => count($data) + 1,
                        'id' => 'P-' . $row->id,
                        'type' => 'Pendapatan',
                        'tanggal' => $tanggal,
                        'keterangan' => 'Donasi dari ' . $row->nama,
                        'detail' => $keteranganPesan,
                        'nominal' => 'Rp ' . number_format($nominal, 0, ',', '.'),
                        'nominal_raw' => $nominal,
                        'bank' => $bank,
                        'nama' => $row->nama,
                        'email' => $row->email,
                    ];
                }
            }

            // Get Pengeluaran
            if (empty($typeFilter) || $typeFilter == 'pengeluaran') {
                $pengeluaranQuery = Pengeluaran::query();

                if (!empty($search)) {
                    $pengeluaranQuery->where(function($q) use ($search) {
                        $q->where('nama_kegiatan', 'like', '%' . $search . '%')
                          ->orWhere('rincian', 'like', '%' . $search . '%')
                          ->orWhere('penanggung_jawab', 'like', '%' . $search . '%');
                    });
                }

                $pengeluaran = $pengeluaranQuery->orderBy('created_at', 'desc')->get();

                foreach ($pengeluaran as $row) {
                    $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                    $rincian = strlen($row->rincian) > 50 ? substr($row->rincian, 0, 50) . '...' : $row->rincian;

                    $data[] = [
                        'DT_RowIndex' => count($data) + 1,
                        'id' => 'E-' . $row->id,
                        'type' => 'Pengeluaran',
                        'tanggal' => $tanggal,
                        'keterangan' => $row->nama_kegiatan,
                        'detail' => $rincian,
                        'nominal' => 'Rp ' . number_format($row->besar_anggaran, 0, ',', '.'),
                        'nominal_raw' => -$row->besar_anggaran, // Negative for pengeluaran
                        'bank' => '-',
                        'nama' => $row->penanggung_jawab,
                        'email' => '-',
                    ];
                }
            }

            // Sort by date descending
            usort($data, function($a, $b) {
                return strtotime(str_replace('/', '-', $b['tanggal'])) - strtotime(str_replace('/', '-', $a['tanggal']));
            });

            // Re-index after sorting
            foreach ($data as $index => &$item) {
                $item['DT_RowIndex'] = $index + 1;
            }

            $totalRecords = count($data);
            $filteredRecords = count($data);

            // Pagination
            $paginatedData = array_slice($data, $start, $length);

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $paginatedData
            ]);
        }

        // Calculate summary
        $totalPendapatan = Donasi::where('transaction_status', 'settlement')
            ->sum(DB::raw('COALESCE(nominal, jumlah, 0)'));
        $totalPengeluaran = Pengeluaran::sum('besar_anggaran');
        $saldo = $totalPendapatan - $totalPengeluaran;

        return view('admin.laporan-keuangan.index', compact('totalPendapatan', 'totalPengeluaran', 'saldo'));
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $typeFilter = $request->get('type', ''); // 'pendapatan' or 'pengeluaran' or ''

        $data = [];

        // Get Pendapatan
        if (empty($typeFilter) || $typeFilter == 'pendapatan') {
            $pendapatan = Donasi::where('transaction_status', 'settlement')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($pendapatan as $row) {
                $noHp = !empty($row->no_hp) ? $row->no_hp : (!empty($row->telepon) ? $row->telepon : '-');
                $nominal = !empty($row->nominal) ? $row->nominal : (!empty($row->jumlah) ? $row->jumlah : 0);
                $keteranganPesan = !empty($row->keterangan_pesan) ? $row->keterangan_pesan : (!empty($row->pesan) ? $row->pesan : '-');
                $bank = $row->bank_display;
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';

                $data[] = [
                    'type' => 'Pendapatan',
                    'tanggal' => $tanggal,
                    'keterangan' => 'Donasi dari ' . $row->nama,
                    'detail' => $keteranganPesan,
                    'nominal' => $nominal,
                    'bank' => $bank,
                    'nama' => $row->nama,
                    'email' => $row->email,
                    'no_hp' => $noHp,
                ];
            }
        }

        // Get Pengeluaran
        if (empty($typeFilter) || $typeFilter == 'pengeluaran') {
            $pengeluaran = Pengeluaran::orderBy('created_at', 'desc')->get();

            foreach ($pengeluaran as $row) {
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';

                $data[] = [
                    'type' => 'Pengeluaran',
                    'tanggal' => $tanggal,
                    'keterangan' => $row->nama_kegiatan,
                    'detail' => $row->rincian,
                    'nominal' => -$row->besar_anggaran,
                    'bank' => '-',
                    'nama' => $row->penanggung_jawab,
                    'email' => '-',
                    'no_hp' => '-',
                ];
            }
        }

        // Sort by date descending
        usort($data, function($a, $b) {
            return strtotime(str_replace('/', '-', $b['tanggal'])) - strtotime(str_replace('/', '-', $a['tanggal']));
        });

        $filename = 'Laporan_Pendapatan_Pengeluaran_' . date('Ymd_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        echo "\xEF\xBB\xBF"; // UTF-8 BOM for Excel

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr style="background-color: #4e73df; color: white;">';
        echo '<th style="padding: 8px; font-weight: bold;">No</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Jenis</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Tanggal</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Keterangan</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Detail</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Nama/Penanggung Jawab</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Email</th>';
        echo '<th style="padding: 8px; font-weight: bold;">No. HP</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Bank</th>';
        echo '<th style="padding: 8px; font-weight: bold;">Nominal</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $no = 1;
        $totalPendapatan = 0;
        $totalPengeluaran = 0;

        foreach ($data as $row) {
            $nominalValue = $row['nominal'];
            if ($row['type'] == 'Pendapatan') {
                $totalPendapatan += $nominalValue;
            } else {
                $totalPengeluaran += abs($nominalValue);
            }

            echo '<tr>';
            echo '<td style="padding: 5px;">' . $no . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['type']) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['tanggal']) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['keterangan']) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['detail']) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['nama']) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['email']) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['no_hp']) . '</td>';
            echo '<td style="padding: 5px;">' . htmlspecialchars($row['bank']) . '</td>';
            echo '<td style="padding: 5px;">Rp ' . number_format(abs($nominalValue), 0, ',', '.') . '</td>';
            echo '</tr>';
            $no++;
        }

        // Summary row
        echo '<tr style="background-color: #f0f0f0; font-weight: bold;">';
        echo '<td colspan="9" style="padding: 8px; text-align: right;">Total Pendapatan:</td>';
        echo '<td style="padding: 8px;">Rp ' . number_format($totalPendapatan, 0, ',', '.') . '</td>';
        echo '</tr>';
        echo '<tr style="background-color: #f0f0f0; font-weight: bold;">';
        echo '<td colspan="9" style="padding: 8px; text-align: right;">Total Pengeluaran:</td>';
        echo '<td style="padding: 8px;">Rp ' . number_format($totalPengeluaran, 0, ',', '.') . '</td>';
        echo '</tr>';
        echo '<tr style="background-color: #e0e0e0; font-weight: bold;">';
        echo '<td colspan="9" style="padding: 8px; text-align: right;">Saldo:</td>';
        echo '<td style="padding: 8px;">Rp ' . number_format($totalPendapatan - $totalPengeluaran, 0, ',', '.') . '</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        exit;
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        $typeFilter = $request->get('type', ''); // 'pendapatan' or 'pengeluaran' or ''

        $data = [];

        // Get Pendapatan
        if (empty($typeFilter) || $typeFilter == 'pendapatan') {
            $pendapatan = Donasi::where('transaction_status', 'settlement')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($pendapatan as $row) {
                $noHp = !empty($row->no_hp) ? $row->no_hp : (!empty($row->telepon) ? $row->telepon : '-');
                $nominal = !empty($row->nominal) ? $row->nominal : (!empty($row->jumlah) ? $row->jumlah : 0);
                $keteranganPesan = !empty($row->keterangan_pesan) ? $row->keterangan_pesan : (!empty($row->pesan) ? $row->pesan : '-');
                $bank = $row->bank_display;
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';

                $data[] = [
                    'type' => 'Pendapatan',
                    'tanggal' => $tanggal,
                    'keterangan' => 'Donasi dari ' . $row->nama,
                    'detail' => $keteranganPesan,
                    'nominal' => $nominal,
                    'bank' => $bank,
                    'nama' => $row->nama,
                    'email' => $row->email,
                    'no_hp' => $noHp,
                ];
            }
        }

        // Get Pengeluaran
        if (empty($typeFilter) || $typeFilter == 'pengeluaran') {
            $pengeluaran = Pengeluaran::orderBy('created_at', 'desc')->get();

            foreach ($pengeluaran as $row) {
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';

                $data[] = [
                    'type' => 'Pengeluaran',
                    'tanggal' => $tanggal,
                    'keterangan' => $row->nama_kegiatan,
                    'detail' => $row->rincian,
                    'nominal' => -$row->besar_anggaran,
                    'bank' => '-',
                    'nama' => $row->penanggung_jawab,
                    'email' => '-',
                    'no_hp' => '-',
                ];
            }
        }

        // Sort by date descending
        usort($data, function($a, $b) {
            return strtotime(str_replace('/', '-', $b['tanggal'])) - strtotime(str_replace('/', '-', $a['tanggal']));
        });

        // Calculate totals
        $totalPendapatan = 0;
        $totalPengeluaran = 0;
        foreach ($data as $row) {
            if ($row['type'] == 'Pendapatan') {
                $totalPendapatan += $row['nominal'];
            } else {
                $totalPengeluaran += abs($row['nominal']);
            }
        }
        $saldo = $totalPendapatan - $totalPengeluaran;

        // Get logo path
        $logoPath = null;
        if (file_exists(public_path('assets/admin/img/logo/pmi-logo.svg'))) {
            $logoPath = asset('assets/admin/img/logo/pmi-logo.svg');
        } elseif (file_exists(public_path('assets/images/favicon.svg'))) {
            $logoPath = asset('assets/images/favicon.svg');
        }

        $html = view('admin.laporan-keuangan.pdf', compact('data', 'totalPendapatan', 'totalPengeluaran', 'saldo', 'logoPath'))->render();

        // Generate PDF using dompdf if available, otherwise return HTML for printing
        if (class_exists('\Dompdf\Dompdf')) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            
            $filename = 'Laporan_Pendapatan_Pengeluaran_' . date('Ymd_His') . '.pdf';
            return $dompdf->stream($filename);
        } else {
            // Fallback: Return HTML with print stylesheet
            // User can print to PDF using browser's print function
            $filename = 'Laporan_Pendapatan_Pengeluaran_' . date('Ymd_His') . '.html';
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
        }
    }
}

