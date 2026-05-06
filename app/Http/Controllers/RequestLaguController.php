<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestLagu;
use Carbon\Carbon;

class RequestLaguController extends Controller
{
    public function index()
    {
        $data = RequestLagu::oldest()->get();
        return view('request_lagu', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_lagu' => 'required',
            'nama_pengirim' => 'required',
        ]);

        $ip = $request->ip();

        $jumlahHariIni = RequestLagu::where('ip_address', $ip)
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($jumlahHariIni >= 6) {
            return redirect()->back()->with('error', 'sudah mencapai batas request hari ini (Maksimal 6 lagu)');
        }

        RequestLagu::create([
            'judul_lagu' => $request->judul_lagu,
            'nama_pengirim' => $request->nama_pengirim,
            'ip_address' => $ip,
            'album_art' => $request->album_art,
            'bagian_lirik' => $request->bagian_lirik,
        ]);

        return redirect()->back()->with('success', 'Request lagu berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $lagu = RequestLagu::findOrFail($id);
        $lagu->delete();

        return redirect()->back()->with('success', 'Lagu berhasil dihapus');
    }
}