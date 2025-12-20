<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
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

            $query = Pengeluaran::query();

            // Search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_kegiatan', 'like', '%' . $search . '%')
                      ->orWhere('rincian', 'like', '%' . $search . '%')
                      ->orWhere('penanggung_jawab', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = Pengeluaran::count();
            $filteredRecords = $query->count();

            $pengeluarans = $query->orderBy('created_at', 'desc')
                ->skip($start)
                ->take($length)
                ->get();

            $data = [];
            foreach ($pengeluarans as $index => $row) {
                $fileLink = $row->file ? '<a href="' . $row->file_url . '" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file"></i> Download</a>' : '-';
                $fotoImg = $row->foto ? '<img src="' . $row->foto_url . '" alt="Foto" style="max-width: 100px; max-height: 100px; cursor: pointer;" onclick="showImageModal(\'' . $row->foto_url . '\')">' : '-';
                
                $data[] = [
                    'DT_RowIndex' => $start + $index + 1,
                    'id' => $row->id,
                    'nama_kegiatan' => $row->nama_kegiatan,
                    'rincian' => strlen($row->rincian) > 50 ? substr($row->rincian, 0, 50) . '...' : $row->rincian,
                    'besar_anggaran' => 'Rp ' . number_format($row->besar_anggaran, 0, ',', '.'),
                    'file' => $fileLink,
                    'penanggung_jawab' => $row->penanggung_jawab,
                    'foto' => $fotoImg,
                ];
            }

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        return view('admin.donasi.pengeluaran');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.donasi.pengeluaran-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'rincian' => 'required|string',
            'besar_anggaran' => 'required|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'penanggung_jawab' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/pengeluaran/files', $fileName);
            $validated['file'] = $fileName;
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/pengeluaran/fotos', $fotoName);
            $validated['foto'] = $fotoName;
        }

        Pengeluaran::create($validated);

        return redirect()->route('admin.donasi.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('admin.donasi.pengeluaran-show', compact('pengeluaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('admin.donasi.pengeluaran-edit', compact('pengeluaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'rincian' => 'required|string',
            'besar_anggaran' => 'required|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'penanggung_jawab' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($pengeluaran->file) {
                Storage::delete('public/pengeluaran/files/' . $pengeluaran->file);
            }
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/pengeluaran/files', $fileName);
            $validated['file'] = $fileName;
        } else {
            $validated['file'] = $pengeluaran->file;
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($pengeluaran->foto) {
                Storage::delete('public/pengeluaran/fotos/' . $pengeluaran->foto);
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/pengeluaran/fotos', $fotoName);
            $validated['foto'] = $fotoName;
        } else {
            $validated['foto'] = $pengeluaran->foto;
        }

        $pengeluaran->update($validated);

        return redirect()->route('admin.donasi.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        // Delete files
        if ($pengeluaran->file) {
            Storage::delete('public/pengeluaran/files/' . $pengeluaran->file);
        }
        if ($pengeluaran->foto) {
            Storage::delete('public/pengeluaran/fotos/' . $pengeluaran->foto);
        }

        $pengeluaran->delete();

        return redirect()->route('admin.donasi.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}

