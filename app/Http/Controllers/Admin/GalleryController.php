<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Check if table exists
                if (!\Schema::hasTable('galleries')) {
                    return response()->json([
                        'draw' => intval($request->get('draw', 1)),
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0,
                        'data' => [],
                    ]);
                }

                $draw = $request->get('draw');
                $start = $request->get('start', 0);
                $length = $request->get('length', 10);
                $searchValue = $request->get('search');
                $search = isset($searchValue['value']) ? $searchValue['value'] : '';

                $query = Gallery::query();

                // Search functionality
                if (!empty($search)) {
                    $hasWhere = false;
                    $query->where(function($q) use ($search, &$hasWhere) {
                        // Check if column exists before using it
                        if (Schema::hasColumn('galleries', 'judul_kegiatan')) {
                            $q->where('judul_kegiatan', 'like', '%' . $search . '%');
                            $hasWhere = true;
                        }
                        if (Schema::hasColumn('galleries', 'judul')) {
                            if ($hasWhere) {
                                $q->orWhere('judul', 'like', '%' . $search . '%');
                            } else {
                                $q->where('judul', 'like', '%' . $search . '%');
                                $hasWhere = true;
                            }
                        }
                        if (Schema::hasColumn('galleries', 'deskripsi')) {
                            if ($hasWhere) {
                                $q->orWhere('deskripsi', 'like', '%' . $search . '%');
                            } else {
                                $q->where('deskripsi', 'like', '%' . $search . '%');
                            }
                        }
                    });
                }

                $totalRecords = Gallery::count();
                $filteredRecords = $query->count();

                // Order by tanggal if exists, otherwise by created_at
                if (Schema::hasColumn('galleries', 'tanggal')) {
                    $galleries = $query->orderBy('tanggal', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->skip($start)
                        ->take($length)
                        ->get();
                } else {
                    // If tanggal column doesn't exist, order by created_at only
                    $galleries = $query->orderBy('created_at', 'desc')
                        ->skip($start)
                        ->take($length)
                        ->get();
                }

            $data = [];
            foreach ($galleries as $index => $row) {
                $gambarImg = '-';
                if (!empty($row->gambar)) {
                    $gambarUrl = $row->gambar_url;
                    if ($gambarUrl) {
                        $gambarImg = '<img src="' . $gambarUrl . '" alt="Gambar" style="max-width: 100px; max-height: 100px; cursor: pointer;" onclick="showImageModal(\'' . $gambarUrl . '\')">';
                    }
                }
                
                $deskripsi = '-';
                if (!empty($row->deskripsi)) {
                    $deskripsi = strlen($row->deskripsi) > 50 ? substr($row->deskripsi, 0, 50) . '...' : $row->deskripsi;
                }
                
                $tanggal = '-';
                if (isset($row->tanggal) && !empty($row->tanggal)) {
                    try {
                        if (is_string($row->tanggal)) {
                            $tanggal = date('d/m/Y', strtotime($row->tanggal));
                        } elseif (is_object($row->tanggal) && method_exists($row->tanggal, 'format')) {
                            $tanggal = $row->tanggal->format('d/m/Y');
                        } else {
                            $tanggal = $row->created_at ? $row->created_at->format('d/m/Y') : '-';
                        }
                    } catch (\Exception $e) {
                        $tanggal = $row->created_at ? $row->created_at->format('d/m/Y') : '-';
                    }
                } elseif ($row->created_at) {
                    $tanggal = $row->created_at->format('d/m/Y');
                }
                
                $judulKegiatan = isset($row->judul_kegiatan) && !empty($row->judul_kegiatan) ? $row->judul_kegiatan : (isset($row->judul) ? $row->judul : '-');
                $aksi = '<a href="/admin/gallery/edit/' . $row->id . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> ' .
                       '<button onclick="deleteGallery(' . $row->id . ')" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                
                $data[] = [
                    'DT_RowIndex' => $start + $index + 1,
                    'id' => $row->id,
                    'gambar' => $gambarImg,
                    'judul_kegiatan' => $judulKegiatan,
                    'deskripsi' => $deskripsi,
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
            } catch (\Exception $e) {
                \Log::error('Gallery DataTables Error: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                    'request' => $request->all()
                ]);
                
                return response()->json([
                    'draw' => intval($request->get('draw', 1)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Terjadi kesalahan saat memuat data. Silakan refresh halaman.'
                ], 200); // Return 200 instead of 500 to avoid DataTables error
            }
        }

        return view('admin.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tanggal' => 'required|date',
        ]);

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambar->storeAs('public/gallery', $gambarName);
            $validated['gambar'] = $gambarName;
        }

        Gallery::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Data gallery berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tanggal' => 'required|date',
        ]);

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            // Delete old gambar
            if ($gallery->gambar) {
                Storage::delete('public/gallery/' . $gallery->gambar);
            }
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambar->storeAs('public/gallery', $gambarName);
            $validated['gambar'] = $gambarName;
        } else {
            $validated['gambar'] = $gallery->gambar;
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Data gallery berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete gambar
        if ($gallery->gambar) {
            Storage::delete('public/gallery/' . $gallery->gambar);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Data gallery berhasil dihapus.');
    }
}

