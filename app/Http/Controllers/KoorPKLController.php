<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;

use App\Http\Requests\KoorPklRequest;
use App\Http\Requests\KoorPklUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class KoorPKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $koorPkl = User::latest()
            ->role('koor-pkl')
            ->get();

        return view ('admin.koor-pkl.index', [
            'koorPkl'  => $koorPkl,
            'user'     => $user,
            'title'    => 'Koor-Pkl'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        return view ('admin.koor-pkl.tambah', [
            'title'    => 'Koor-Pkl'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KoorPklRequest $request)
    {
        DB::beginTransaction();

        try {
            $nomorWa = $request->input('wa');
            
            if (substr($nomorWa, 0, 1) === '0') {
                $wa = '62' . substr($nomorWa, 1);
            } else {
                $wa = 62 . $nomorWa;
            }

            $user = auth()->user();

            $image = User::saveImage($request);

            $user = User::create([
                'name'        => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email'       => $request->email,
                'wa'          => $wa,
                'jurusan_id'  => $user->jurusan->id,
                'password'    => Hash::make($request->nomor_induk),
                'image'       => $image
            ]);

            $user->assignRole('koor-pkl');

            DB::commit();

            return redirect()->route('koorPkl.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Koordinator PKL Gagal Ditambah');
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

        $koorPkl = User::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();

        return view ('admin.koor-pkl.detail', [
            'koorPkl' => $koorPkl,
            'jurusan'   => $jurusan,
            'title'    => 'Koor-Pkl'
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

        $koorPkl = User::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();

        return view ('admin.koor-pkl.edit', [
            'koorPkl' => $koorPkl,
            'jurusan'   => $jurusan,
            'title'    => 'Koor-Pkl'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email,' .  $id,
            'nomor_induk'       => 'required|unique:users,nomor_induk,' . $id,
            'wa'                => 'required',
        ], [
            'name.required'         => 'Nama Koordinator PKL Wajib Diisi',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'nomor_induk.required'  => 'NIP Wajib Diisi',
            'nomor_induk.unique'    => 'NIP Sudah Ada',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'email.unique'          => 'Email Sudah Digunakan'
        ]);

        $nomorWa = $request->input('wa');
            
        if (substr($nomorWa, 0, 1) === '0') {
            $wa = '62' . substr($nomorWa, 1);
        } else {
            $wa = 62 . $nomorWa;
        }

        $user = auth()->user();
        
        $data = [
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => $wa,
            'jurusan_id'  => $user->jurusan->id,
            'password'    => Hash::make($request->nomor_induk),
        ];
        
        $image = User::saveImage($request);
        
        if ($image) {
            $data['image'] = $image;

            User::deleteImage($id);
        }

        User::where('id', $id)->update($data);
            
        return redirect()->route('koorPkl.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $koorPkl = User::find($id);

        User::deleteImage($id);

        $koorPkl->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
