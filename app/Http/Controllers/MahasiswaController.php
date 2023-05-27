<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\ProgramStudi;

use App\Http\Requests\MahasiswaRequest;
use App\Http\Requests\MahasiswaUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::where('status', 'Mahasiswa Aktif' || 'Keluar')
        ->get();

        return view ('admin.mahasiswa.index', [
            'mahasiswa' => $mahasiswa,
            'title'     => 'Mahasiswa'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan    =   Jurusan::get();
        $prodi      =   ProgramStudi::get();
        
        return view ('admin.mahasiswa.form', [
            'jurusan'   =>  $jurusan,
            'prodi'     =>  $prodi,
            'title'     => 'Mahasiswa'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'        => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email'       => $request->email,
                'wa'          => 62 . $request->wa,
                'password'    => Hash::make($request->nomor_induk)
            ]);

            $data = [
                'user_id'           => $user->id,
                'nim'               => $user->nomor_induk,
                'angkatan'          => $request->angkatan,
                'jurusan_id'        => $request->jurusan_id,
                'program_studi_id'  => $request->program_studi_id,
                'status'            => $request->status
            ];

            $image = Mahasiswa::saveImage($request);

            $data['image'] = $image;

            $mahasiswa = Mahasiswa::create($data);

            if ($request->status == 'Alumni') {
                $user->assignRole('alumni');
                
            } else {
                $user->assignRole('mahasiswa');

            }

            DB::commit();

            return redirect()->route('mahasiswa.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Mahasiswa Gagal Ditambah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();
        $prodi = ProgramStudi::oldest('name')->get();

        return view ('admin.mahasiswa.form', [
            'mahasiswa' => $mahasiswa,
            'jurusan'   => $jurusan,
            'prodi'     => $prodi,
            'title'     => 'Mahasiswa'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MahasiswaUpdateRequest $request, Mahasiswa $mahasiswa)
    {
        $data = [
            'nim'               => $request->nomor_induk,
            'angkatan'          => $request->angkatan,
            'jurusan_id'        => $request->jurusan_id,
            'program_studi_id'  => $request->program_studi_id,
            'status'            => $request->status,
        ];

        $image = Mahasiswa::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            $param = (object) [
                'type'  => 'image',
                'id'    => $mahasiswa->id
            ];

            Mahasiswa::deleteImage($param);
        }

        Mahasiswa::where('id', $mahasiswa->id)->update($data);

        User::whereId($mahasiswa->user_id)->update([
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => 62 . $request->wa,
            // 'password'    => Hash::make($request->nomor_induk)
        ]);
      
        return redirect()->route('mahasiswa.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        // $resellerOrder =  ResellerOrder::where('reseller_id', $id)
        //     ->whereNotIn('order_status_id', [8, 9])
        //     ->first();

        // if ($resellerOrder) {
        //     return response()->json(['message' => 'Gagal hapus, masih ada transaksi yang berjalan', 'status' => 'error', 'code' => '500']);
        // }

        $param = (object) [
            'type'  => 'image',
            'id'    => $mahasiswa->id
        ];

        Mahasiswa::deleteImage($param);

        // $this->deleteMahasiswa($id);

        $mahasiswa->delete();

        User::where('id', $mahasiswa->user_id)->update(['status' => '0']);

        return response()->json(['status' => 'Data Berhasil Dihapus']);
    }
}
