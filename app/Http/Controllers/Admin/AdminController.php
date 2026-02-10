<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Update last login
            Auth::user()->update([
                'last_login' => now()
            ]);

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak valid.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Total Pendapatan (dari donasi dengan status settlement)
        $totalPendapatan = \App\Models\Donasi::where('transaction_status', 'settlement')
            ->sum('jumlah');

        // Total Pengeluaran
        $totalPengeluaran = \App\Models\Pengeluaran::sum('besar_anggaran');

        // Jumlah Donatur (unique donatur yang sudah settlement)
        $jumlahDonatur = \App\Models\Donasi::where('transaction_status', 'settlement')
            ->distinct()
            ->count('email');

        // Jumlah Kegiatan (total gallery)
        $jumlahKegiatan = \App\Models\Gallery::count();

        // 3 Donasi Terbaru
        $donasiTerbaru = \App\Models\Donasi::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Data untuk grafik pemasukan bulanan (12 bulan terakhir)
        $bulanan = [];
        $labels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulan = $date->format('M');
            $labels[] = $bulan;

            $pemasukan = \App\Models\Donasi::where('transaction_status', 'settlement')
                ->whereYear('settlement_time', $date->year)
                ->whereMonth('settlement_time', $date->month)
                ->sum('jumlah');

            $bulanan[] = $pemasukan;
        }

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalPengeluaran',
            'jumlahDonatur',
            'jumlahKegiatan',
            'donasiTerbaru',
            'bulanan',
            'labels'
        ));
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil logout.');
    }
}
