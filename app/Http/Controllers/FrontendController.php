<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Berita;
use App\Models\Gallery;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class FrontendController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Ambil donasi terbaru dengan status_code = 200 - limit 3
            $pendonasi = Donasi::where('status_code', '200')
                ->whereNotNull('nama')
                ->select('*') // Pastikan semua field termasuk pesan di-load
                ->orderBy('settlement_time', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            // Jika tabel belum ada, gunakan collection kosong
            $pendonasi = collect([]);
        }

        try {
            // Cek apakah tabel beritas ada
            if (Schema::hasTable('beritas')) {
                // Ambil berita terbaru yang dipublikasikan (minimal 5 untuk horizontal scroll)
                $beritas = Berita::with('kategori')
                    ->published()
                    ->latest()
                    ->limit(10)
                    ->get();
            } else {
                $beritas = collect([]);
            }
        } catch (\Exception $e) {
            $beritas = collect([]);
        }

        try {
            // Cek apakah tabel galleries ada
            if (Schema::hasTable('galleries')) {
                // Ambil galeri terbaru
                $galleries = Gallery::orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get();
            } else {
                $galleries = collect([]);
            }
        } catch (\Exception $e) {
            $galleries = collect([]);
        }

        // Data Pemasukan (Donasi dengan status_code = 200)
        try {
            $pemasukan = Donasi::where('status_code', '200')
                ->orderBy('settlement_time', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Hitung subtotal
            $subtotalPemasukan = $pemasukan->sum(function($item) {
                return !empty($item->jumlah) ? $item->jumlah : 0;
            });
        } catch (\Exception $e) {
            $pemasukan = collect([]);
            $subtotalPemasukan = 0;
        }

        // Data Pengeluaran
        try {
            if (Schema::hasTable('pengeluarans')) {
                $pengeluaran = Pengeluaran::orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
            } else {
                $pengeluaran = collect([]);
            }
        } catch (\Exception $e) {
            $pengeluaran = collect([]);
        }

        return view('frontend.home', compact('pendonasi', 'beritas', 'galleries', 'pemasukan', 'pengeluaran', 'subtotalPemasukan'));
    }

    /**
     * Display the berita page.
     *
     * @return \Illuminate\View\View
     */
    public function berita(Request $request)
    {
        try {
            // Initialize default values
            $beritas = new LengthAwarePaginator([], 0, 9, 1, ['path' => $request->url(), 'query' => $request->query()]);
            $kategoris = collect([]);

            // Check if beritas table exists
            if (Schema::hasTable('beritas')) {
                try {
                    $query = Berita::with('kategori')
                        ->published()
                        ->latest();

                    // Search functionality
                    if ($request->has('search') && $request->search) {
                        $query->where(function($q) use ($request) {
                            $q->where('judul', 'like', '%' . $request->search . '%')
                              ->orWhere('ringkasan', 'like', '%' . $request->search . '%')
                              ->orWhere('konten', 'like', '%' . $request->search . '%');
                        });
                    }

                    // Filter by kategori
                    if ($request->has('kategori') && $request->kategori) {
                        $query->where('kategori_berita_id', $request->kategori);
                    }

                    $beritas = $query->paginate(9);
                } catch (\Exception $e) {
                    \Log::error('Error querying beritas: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
                }
            }

            // Check if kategori_beritas table exists
            if (Schema::hasTable('kategori_beritas')) {
                try {
                    $kategoris = \App\Models\KategoriBerita::where('is_active', true)->get();
                } catch (\Exception $e) {
                    \Log::error('Error loading kategoris: ' . $e->getMessage());
                }
            }

            return view('frontend.berita.index', compact('beritas', 'kategoris'));
        } catch (\Exception $e) {
            \Log::error('Fatal error in berita method: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            
            // Return minimal view even on error
            $beritas = new LengthAwarePaginator([], 0, 9, 1, ['path' => $request->url(), 'query' => $request->query()]);
            $kategoris = collect([]);
            
            try {
                return view('frontend.berita.index', compact('beritas', 'kategoris'));
            } catch (\Exception $viewException) {
                \Log::error('Error rendering view: ' . $viewException->getMessage());
                abort(500, 'Error loading page. Please check logs.');
            }
        }
    }

    /**
     * Display single berita detail.
     *
     * @return \Illuminate\View\View
     */
    public function beritaDetail($slug)
    {
        $berita = Berita::with('kategori')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $berita->views = (isset($berita->views) && $berita->views ? $berita->views : 0) + 1;
        $berita->save();

        // Get related berita
        $relatedBeritas = Berita::with('kategori')
            ->where('kategori_berita_id', $berita->kategori_berita_id)
            ->where('id', '!=', $berita->id)
            ->published()
            ->latest()
            ->limit(4)
            ->get();

        return view('frontend.berita.detail', compact('berita', 'relatedBeritas'));
    }

    /**
     * Display the gallery page.
     *
     * @return \Illuminate\View\View
     */
    public function gallery()
    {
        $galleries = Gallery::orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.gallery.index', compact('galleries'));
    }

    /**
     * Export laporan keuangan (Excel/PDF)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportLaporan(Request $request)
    {
        $type = $request->get('type', 'pemasukan'); // pemasukan or pengeluaran
        $format = $request->get('format', 'excel'); // excel or pdf

        if ($type === 'pemasukan') {
            $data = Donasi::where('status_code', '200')
                ->orderBy('settlement_time', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $filename = 'Laporan_Pemasukan_' . date('Ymd_His');
            $headers = ['No', 'Tanggal', 'Jumlah Donasi'];
            
            if ($format === 'excel') {
                return $this->exportExcel($data, $filename, $headers, 'pemasukan');
            } else {
                return $this->exportPDF($data, $filename, $headers, 'pemasukan');
            }
        } else {
            $data = Pengeluaran::orderBy('created_at', 'desc')->get();
            
            $filename = 'Laporan_Pengeluaran_' . date('Ymd_His');
            $headers = ['No', 'Jenis', 'Tanggal', 'Keterangan', 'Detail', 'Nama/Penanggung Jawab', 'Bank', 'Nominal'];
            
            if ($format === 'excel') {
                return $this->exportExcel($data, $filename, $headers, 'pengeluaran');
            } else {
                return $this->exportPDF($data, $filename, $headers, 'pengeluaran');
            }
        }
    }

    /**
     * Export to Excel
     */
    private function exportExcel($data, $filename, $headers, $type)
    {
        $html = '<html><head><meta charset="utf-8"></head><body>';
        $html .= '<table border="1">';
        
        // Header
        $html .= '<tr style="background-color: #DC143C; color: #fff; font-weight: bold;">';
        foreach ($headers as $header) {
            $html .= '<th style="padding: 10px;">' . $header . '</th>';
        }
        $html .= '</tr>';
        
        // Data
        $no = 1;
        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td style="padding: 8px;">' . $no . '</td>';
            
            if ($type === 'pemasukan') {
                $tanggal = $row->settlement_time ? $row->settlement_time->format('d M Y') : ($row->created_at ? $row->created_at->format('d M Y') : '-');
                $jumlah = !empty($row->jumlah) ? $row->jumlah : 0;
                
                $html .= '<td style="padding: 8px;">' . $tanggal . '</td>';
                $html .= '<td style="padding: 8px;">Rp ' . number_format($jumlah, 0, ',', '.') . '</td>';
            } else {
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                $namaKegiatan = !empty($row->nama_kegiatan) ? $row->nama_kegiatan : '-';
                $rincian = !empty($row->rincian) ? $row->rincian : '-';
                $anggaran = !empty($row->besar_anggaran) ? $row->besar_anggaran : 0;
                $penanggungJawab = !empty($row->penanggung_jawab) ? $row->penanggung_jawab : '-';
                
                $html .= '<td style="padding: 8px;">Pengeluaran</td>';
                $html .= '<td style="padding: 8px;">' . $tanggal . '</td>';
                $html .= '<td style="padding: 8px;">' . htmlspecialchars($namaKegiatan) . '</td>';
                $html .= '<td style="padding: 8px;">' . htmlspecialchars($rincian) . '</td>';
                $html .= '<td style="padding: 8px;">' . htmlspecialchars($penanggungJawab) . '</td>';
                $html .= '<td style="padding: 8px;">-</td>';
                $html .= '<td style="padding: 8px;">Rp ' . number_format($anggaran, 0, ',', '.') . '</td>';
            }
            
            $html .= '</tr>';
            $no++;
        }
        
        $html .= '</table>';
        $html .= '</body></html>';
        
        return response($html, 200)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment;filename="' . $filename . '.xls"')
            ->header('Cache-Control', 'max-age=0');
    }

    /**
     * Export to PDF
     */
    private function exportPDF($data, $filename, $headers, $type)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>' . $filename . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2 { color: #DC143C; text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background-color: #DC143C; color: #fff; padding: 10px; text-align: left; }
                td { padding: 8px; border-bottom: 1px solid #ddd; }
                tr:hover { background-color: #f5f5f5; }
            </style>
        </head>
        <body>
            <h2>Laporan ' . ucfirst($type) . '</h2>
            <p style="text-align: center;">Tanggal: ' . date('d M Y H:i') . '</p>
            <table>
                <thead>
                    <tr>';
        
        foreach ($headers as $header) {
            $html .= '<th>' . $header . '</th>';
        }
        
        $html .= '</tr>
                </thead>
                <tbody>';
        
        $no = 1;
        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $no . '</td>';
            
            if ($type === 'pemasukan') {
                $tanggal = $row->settlement_time ? $row->settlement_time->format('d M Y') : ($row->created_at ? $row->created_at->format('d M Y') : '-');
                $jumlah = !empty($row->jumlah) ? $row->jumlah : 0;
                
                $html .= '<td>' . $tanggal . '</td>';
                $html .= '<td>Rp ' . number_format($jumlah, 0, ',', '.') . '</td>';
            } else {
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                $namaKegiatan = !empty($row->nama_kegiatan) ? $row->nama_kegiatan : '-';
                $rincian = !empty($row->rincian) ? $row->rincian : '-';
                $anggaran = !empty($row->besar_anggaran) ? $row->besar_anggaran : 0;
                $penanggungJawab = !empty($row->penanggung_jawab) ? $row->penanggung_jawab : '-';
                
                $html .= '<td>Pengeluaran</td>';
                $html .= '<td>' . $tanggal . '</td>';
                $html .= '<td>' . htmlspecialchars($namaKegiatan) . '</td>';
                $html .= '<td>' . htmlspecialchars($rincian) . '</td>';
                $html .= '<td>' . htmlspecialchars($penanggungJawab) . '</td>';
                $html .= '<td>-</td>';
                $html .= '<td>Rp ' . number_format($anggaran, 0, ',', '.') . '</td>';
            }
            
            $html .= '</tr>';
            $no++;
        }
        
        $html .= '</tbody>
            </table>
        </body>
        </html>';
        
        // Force download - browser will download as PDF file
        // Note: This creates an HTML file that can be printed to PDF
        // For true PDF generation, install dompdf: composer require dompdf/dompdf
        return response($html, 200)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.pdf"')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');
    }
}

