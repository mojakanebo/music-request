<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestLagu;

class AdminController extends Controller
{
    public function index()
    {
        $requests = RequestLagu::with('user')->oldest()->get();
        
        // Menghitung siswa yang aktif (session dalam 15 menit terakhir)
        $activeSiswaCount = \Illuminate\Support\Facades\DB::table('sessions')
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->where('users.role', 'siswa')
            ->where('sessions.last_activity', '>=', now()->subMinutes(15)->getTimestamp())
            ->distinct('sessions.user_id')
            ->count('sessions.user_id');

        return view('admin.dashboard', compact('requests', 'activeSiswaCount'));
    }

    public function destroy($id)
    {
        $lagu = RequestLagu::findOrFail($id);
        $lagu->delete();

        return redirect()->back()->with('success', 'Request berhasil dihapus');
    }
}
