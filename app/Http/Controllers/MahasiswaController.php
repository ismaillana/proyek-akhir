<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\ProgramStudi;
use Spatie\Permission\Models\Role;

use App\Http\Requests\MahasiswaRequest;
use App\Http\Requests\MahasiswaUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $sale         = 'active';

        $status = $request->status ? $request->status : null;

        $param = (object) [
            'status'            => $request->status,
        ];

        $mahasiswa = Mahasiswa::filter($param)
        ->latest()
        ->get();

        return view ('admin.mahasiswa.index', [
            'mahasiswa' => $mahasiswa,
            'status'    => $status,
            'sale'      => $sale,
            'title'     => 'Data Mahasiswa Alumni'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createImport()
    {
        $jurusan    =   Jurusan::get();
        $prodi      =   ProgramStudi::get();
        
        return view ('admin.mahasiswa.formImport', [
            'jurusan'   =>  $jurusan,
            'prodi'     =>  $prodi,
            'title'     => 'Form Import Mahasiswa'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan    =   Jurusan::get();
        $prodi      =   ProgramStudi::get();
        $roles      =   Role::all();
        
        return view ('admin.mahasiswa.form', [
            'jurusan'   =>  $jurusan,
            'prodi'     =>  $prodi,
            'roles'     =>  $roles,
            'title'     => 'Form Tambah Mahasiswa'
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
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'semester'      => $request->semester,
                'tahun_ajaran'  => $request->tahun_ajaran,
                'orang_tua'     => $request->orang_tua,
                'pekerjaan'     => $request->pekerjaan,
                'nip_nrp'       => $request->nip_nrp,
                'pangkat'       => $request->pangkat,
                'jabatan'       => $request->jabatan,
                'instansi'      => $request->instansi,
                'status'            => $request->status
            ];

            $image = Mahasiswa::saveImage($request);

            $data['image'] = $image;

            $mahasiswa = Mahasiswa::create($data);

            if ($request->status == 'Alumni') {
                $user->assignRole('alumni');
            }else {
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
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $mahasiswa = Mahasiswa::findOrFail($id);
        $jurusan = Jurusan::oldest('name')->get();
        $prodi = ProgramStudi::oldest('name')->get();

        return view ('admin.mahasiswa.detail', [
            'mahasiswa' => $mahasiswa,
            'jurusan'   => $jurusan,
            'prodi'     => $prodi,
            'title'     => 'Mahasiswa'
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

        $mahasiswa = Mahasiswa::findOrFail($id);
        $jurusan   = Jurusan::oldest('name')->get();
        $prodi     = ProgramStudi::oldest('name')->get();

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
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'semester'      => $request->semester,
            'tahun_ajaran'  => $request->tahun_ajaran,
            'orang_tua'     => $request->orang_tua,
            'pekerjaan'     => $request->pekerjaan,
            'nip_nrp'       => $request->nip_nrp,
            'pangkat'       => $request->pangkat,
            'jabatan'       => $request->jabatan,
            'instansi'      => $request->instansi,
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

        $user = User::whereId($mahasiswa->user_id)->update([
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
            'wa'          => 62 . $request->wa,
            'password'    => Hash::make($request->nomor_induk)
        ]);

        $user = User::where('id',$mahasiswa->user_id)->first();
        if ($request->status == 'Alumni') {
            $user->syncRoles('alumni');
        }else {
            $user->syncRoles('mahasiswa');
        }
        

        return redirect()->route('mahasiswa.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
