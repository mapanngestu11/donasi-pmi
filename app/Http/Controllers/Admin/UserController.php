<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
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

            $query = User::query();

            // Search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('username', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('hak_aksis', 'like', '%' . $search . '%');
                });
            }

            $totalRecords = User::count();
            $filteredRecords = $query->count();

            $users = $query->orderBy('created_at', 'desc')
                ->skip($start)
                ->take($length)
                ->get();

            $data = [];
            foreach ($users as $index => $row) {
                $hakAksis = ucfirst($row->hak_aksis);
                $badge = 'secondary';
                if ($row->hak_aksis == 'admin') {
                    $badge = 'danger';
                } elseif ($row->hak_aksis == 'superadmin') {
                    $badge = 'dark';
                } elseif ($row->hak_aksis == 'user') {
                    $badge = 'info';
                }
                
                $hakAksisBadge = '<span class="badge badge-' . $badge . '">' . $hakAksis . '</span>';
                
                $lastLogin = $row->last_login 
                    ? $row->last_login->format('d/m/Y H:i') 
                    : '<span class="text-muted">Belum pernah login</span>';
                
                $tanggal = $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                
                $data[] = [
                    'DT_RowIndex' => $start + $index + 1,
                    'name' => $row->name,
                    'username' => $row->username ? $row->username : '-',
                    'email' => $row->email,
                    'hak_aksis' => $hakAksisBadge,
                    'last_login' => $lastLogin,
                    'tanggal' => $tanggal,
                    'action' => '<a href="' . route('admin.user.edit', $row->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> ' .
                        '<button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(' . $row->id . ')" title="Hapus"><i class="fas fa-trash"></i></button>'
                ];
            }

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'hak_aksis' => 'required|in:superadmin,admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hak_aksis' => $request->hak_aksis,
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'hak_aksis' => 'required|in:superadmin,admin,user',
        ];

        // Password validation only if provided
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'hak_aksis' => $request->hak_aksis,
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting own account
        if ($user->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun sendiri.'
            ], 422);
        }
        
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus.'
        ]);
    }
}

