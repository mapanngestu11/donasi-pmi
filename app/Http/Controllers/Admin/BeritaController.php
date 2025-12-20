<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
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

            $query = Berita::with('kategori');

            // Search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('ringkasan', 'like', '%' . $search . '%')
                      ->orWhereHas('kategori', function($q) use ($search) {
                          $q->where('nama', 'like', '%' . $search . '%');
                      });
                });
            }

            $totalRecords = Berita::count();
            $filteredRecords = $query->count();

            $beritas = $query->orderBy('created_at', 'desc')
                ->skip($start)
                ->take($length)
                ->get();

            $data = [];
            foreach ($beritas as $index => $row) {
                $statusBadge = $row->is_published 
                    ? '<span class="badge badge-success">Published</span>' 
                    : '<span class="badge badge-warning">Draft</span>';
                
                $gambar = $row->gambar 
                    ? '<img src="' . asset('storage/' . $row->gambar) . '" alt="' . $row->judul . '" style="max-width: 100px; max-height: 60px; object-fit: cover;">'
                    : '<span class="text-muted">Tidak ada gambar</span>';
                
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                
                $data[] = [
                    'DT_RowIndex' => $start + $index + 1,
                    'gambar' => $gambar,
                    'judul' => $row->judul,
                    'kategori' => $row->kategori ? $row->kategori->nama : '-',
                    'penulis' => $row->penulis ? $row->penulis : '-',
                    'views' => number_format($row->views, 0, ',', '.'),
                    'status' => $statusBadge,
                    'tanggal' => $tanggal,
                    'action' => '<a href="' . route('admin.berita.edit', $row->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> ' .
                        '<button type="button" class="btn btn-sm btn-danger" onclick="deleteBerita(' . $row->id . ')" title="Hapus"><i class="fas fa-trash"></i></button>'
                ];
            }

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        return view('admin.berita.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriBerita::where('is_active', true)->get();
        return view('admin.berita.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_berita_id' => 'required|exists:kategori_beritas,id',
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penulis' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $data = $request->except(['gambar', 'is_published']);
        $data['slug'] = Str::slug($request->judul);
        $data['is_published'] = $request->has('is_published') ? true : false;
        
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = time() . '_' . Str::random(10) . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('berita', $filename, 'public');
            $data['gambar'] = $path;
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $kategoris = KategoriBerita::where('is_active', true)->get();
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'kategori_berita_id' => 'required|exists:kategori_beritas,id',
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penulis' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $data = $request->except(['gambar', 'is_published', 'remove_image']);
        $data['slug'] = Str::slug($request->judul);
        $data['is_published'] = $request->has('is_published') ? true : false;
        
        // Handle gambar
        if ($request->hasFile('gambar')) {
            // Delete old image jika ada
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            
            // Upload gambar baru
            $gambar = $request->file('gambar');
            $filename = time() . '_' . Str::random(10) . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('berita', $filename, 'public');
            $data['gambar'] = $path;
        } elseif ($request->has('remove_image') && $request->remove_image == '1') {
            // Hapus gambar jika user memilih untuk menghapus
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = null;
        }
        // Jika tidak ada file baru dan tidak ada request hapus, gambar lama tetap digunakan (tidak perlu update field gambar)

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Delete image if exists
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus.'
        ]);
    }
}

