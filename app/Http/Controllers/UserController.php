<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->is_admin == 1) {
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }

            Auth::logout();
            return back()->withErrors(['login_error' => 'Akses ditolak! Anda bukan Administrator.']);
        }

        return back()->withErrors(['login_error' => 'Email atau password yang Anda masukkan salah.'])->withInput($request->only('email'));
    }

    public function adminPengaduan()
    {
        $tickets = Ticket::with('progress')->orderBy('created_at', 'desc')->get();
        
        return view('admin.pengaduan-user', compact('tickets'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function adminDashboard()
    {
        $totalTickets = DB::table('tickets')->count();
        $statusDiterima = DB::table('ticket_progress')->where('status', 'Diterima')->count();
        $statusDiverifikasi = DB::table('ticket_progress')->where('status', 'Diverifikasi')->count();
        $statusDiproses  = DB::table('ticket_progress')->where('status', 'Diproses')->count();
        $statusSelesai  = DB::table('ticket_progress')->where('status', 'Selesai')->count();

        $gratifikasi = DB::table('tickets')->where('jenis_pengaduan', 'gratifikasi')->count();
        $benturanKepentingan = DB::table('tickets')->where('jenis_pengaduan', 'benturan_kepentingan')->count();
        $korupsi = DB::table('tickets')->where('jenis_pengaduan', 'korupsi')->count();
        $pelanggaranAturan = DB::table('tickets')->where('jenis_pengaduan', 'pelanggaran_aturan')->count();
        $lainnya = DB::table('tickets')->where('jenis_pengaduan', 'lainnya')->count();

        return view('admin.dashboard', compact(
            'totalTickets',
            'statusDiterima',
            'statusDiverifikasi', 
            'statusDiproses', 
            'statusSelesai',
            'gratifikasi', 
            'benturanKepentingan', 
            'korupsi', 
            'pelanggaranAturan', 
            'lainnya'
        ));
    }

    public function userIndex()
    {
        $users = User::latest()->get();
        return view('admin.manage-user', compact('users'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nomor_hp' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'is_admin' => 1, 
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route('admin.manage-user')->with('success', 'Data Admin berhasil disimpan!');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'nomor_hp' => 'required|string|max:15',
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nomor_hp = $request->nomor_hp;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.manage-user')->with('success', 'Data Admin berhasil diperbarui!');
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.manage-user')->with('success', 'Data Admin berhasil dihapus!');
    }
}