<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestLagu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cek apakah user ini sudah request hari ini (limit personal)
        $hasRequestedToday = RequestLagu::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->exists();
            
        // Cek total request global hari ini (kuota sekolah)
        $globalRequestsToday = RequestLagu::whereDate('created_at', Carbon::today())->count();
        $isGlobalLimitReached = $globalRequestsToday >= 3;
            
        $myRequests = RequestLagu::where('user_id', $user->id)->oldest()->get();

        return view('siswa.dashboard', compact('hasRequestedToday', 'isGlobalLimitReached', 'myRequests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_lagu' => 'required',
            'nama_pengirim' => 'required',
        ]);

        // Cek limit global
        $globalRequestsToday = RequestLagu::whereDate('created_at', Carbon::today())->count();
        if ($globalRequestsToday >= 3) {
            return redirect()->back()->with('error', 'Maaf, kuota request lagu untuk hari ini (3 lagu) sudah penuh.');
        }

        $user = Auth::user();

        // Cek limit personal
        $jumlahHariIni = RequestLagu::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($jumlahHariIni >= 1) {
            return redirect()->back()->with('error', 'Anda hanya bisa request 1 lagu per hari.');
        }

        RequestLagu::create([
            'judul_lagu' => $request->judul_lagu,
            'nama_pengirim' => $request->nama_pengirim,
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'album_art' => $request->album_art,
            'bagian_lirik' => $request->bagian_lirik,
        ]);

        return redirect()->back()->with('success', 'Request lagu berhasil dikirim!');
    }
}
