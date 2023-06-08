<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Legalisir;
use App\Models\Log;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['legalisir'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Legalisir";

        $legalisir = Legalisir::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->get();

        return view('user.riwayat.legalisir.index', [
            'legalisir'   => $legalisir,
            'title'            => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function tracking(string $id)
    {
        $jumlah = Log::where('legalisir_id', $id)->count();
        
        $log = Log::where('legalisir_id', $id)->latest()
            ->get();

        return view ('user.riwayat.legalisir.tracking', [
            'log'   =>  $log,
            'jumlah'=>  $jumlah
        ]);
    }




    
}
