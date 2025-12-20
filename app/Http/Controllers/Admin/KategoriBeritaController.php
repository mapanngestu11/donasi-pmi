<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
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

            $query = KategoriBerita::withCount('beritas');

            // Search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = KategoriBerita::count();
            $filteredRecords = $query->count();

            $kategoris = $query->orderBy('created_at', 'desc')
                ->skip($start)
                ->take($length)
                ->get();

            $data = [];
            foreach ($kategoris as $index => $row) {
                $statusBadge = $row->is_active 
                    ? '<span class="badge badge-success">Aktif</span>' 
                    : '<span class="badge badge-secondary">Tidak Aktif</span>';
                
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y') : '-';
                
                $data[] = [
                    'DT_RowIndex' => $start + $index + 1,
                    'nama' => $row->nama,
                    'deskripsi' => $row->deskripsi ? (strlen($row->deskripsi) > 50 ? substr($row->deskripsi, 0, 50) . '...' : $row->deskripsi) : '-',
                    'jumlah_berita' => $row->beritas_count,
                    'status' => $statusBadge,
                    'tanggal' => $tanggal,
                    'action' => '<button type="button" class="btn btn-sm btn-warning" onclick="editKategori(' . $row->id . ')" title="Edit"><i class="fas fa-edit"></i></button> ' .
                        '<button type="button" class="btn btn-sm btn-danger" onclick="deleteKategori(' . $row->id . ')" title="Hapus"><i class="fas fa-trash"></i></button>'
                ];
            }

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        return view('admin.berita.kategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_beritas,nama',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('is_active');
        $data['slug'] = Str::slug($request->nama);
        $data['is_active'] = $request->has('is_active') ? true : false;

        KategoriBerita::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.'
        ]);
    }

    /**
     * Get kategori data for edit
     */
    public function show($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        return response()->json($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_beritas,nama,' . $id,
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('is_active');
        $data['slug'] = Str::slug($request->nama);
        $data['is_active'] = $request->has('is_active') ? true : false;

        $kategori->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        
        // Check if kategori has beritas
        if ($kategori->beritas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki berita.'
            ], 422);
        }
        
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.'
        ]);
    }
}

