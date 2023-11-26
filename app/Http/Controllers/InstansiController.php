<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Pengajuan;

use App\Http\Requests\InstansiRequest;
use App\Http\Requests\InstansiUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $pengajuan = Pengajuan::get();
        $instansi = Instansi::latest()
            ->get();

        return view ('admin.instansi.index', [
            'instansi' => $instansi,
            'pengajuan'=> $pengajuan,
            'title'    => 'Instansi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.instansi.form', [
            'title'    => 'Instansi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstansiRequest $request)
    {
        DB::beginTransaction();

        try {
            $nomorWa = $request->input('wa');
            
            if (substr($nomorWa, 0, 1) === '0') {
                $wa = '62' . substr($nomorWa, 1);
            } else {
                $wa = 62 . $nomorWa;
            }
            
            $user = User::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'wa'          => $wa,
                'password'    => Hash::make('123456'),
                'email_verified_at' => now(),
                'password'    => Hash::make($request->password)
            ]);

            $user->assignRole('instansi');

            $data = [
                'user_id'           => $user->id,
                'nama_perusahaan'   => $user->name,
                'alamat'            => $request->alamat,
            ];

            $instansi = Instansi::create($data);

            DB::commit();

            return redirect()->route('instansi.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Instansi Gagal Ditambah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $instansi = Instansi::find($id);

        return view ('admin.instansi.detail', [
            'instansi'  => $instansi,
            'title'    => 'Instansi'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $instansi = Instansi::find($id);

        return view ('admin.instansi.form', [
            'instansi'  => $instansi,
            'title'    => 'Instansi'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstansiUpdateRequest $request, Instansi $instansi)
    {
        $nomorWa = $request->input('wa');
            
        if (substr($nomorWa, 0, 1) === '0') {
            $wa = '62' . substr($nomorWa, 1);
        } else {
            $wa = 62 . $nomorWa;
        }

        $data = [
            'nama_perusahaan'   => $request->name,
            'alamat'            => $request->alamat,
        ];

        Instansi::where('id', $instansi->id)->update($data);
        
        $userData = [
            'name'        => $request->name,
            'email'       => $request->email,
            'wa'          => $wa,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password'      => 'min:3',
            ], [
                'password.min'  => 'Password minimal 3 huruf/angka',
            ]);

            $userData['password'] = Hash::make($request->password);
        }
    
        User::whereId($instansi->user_id)->update($userData);

        return redirect()->route('instansi.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

            $instansi = Instansi::find($id);
            
            $instansi->delete();
            
            $user = User::where('id', $instansi->user_id)->first();

            $user->delete();
    
            return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
