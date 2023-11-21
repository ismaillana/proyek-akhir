<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Spatie\Permission\Models\Role;
use App\Models\Jurusan;

use App\Http\Requests\MahasiswaRequest;
use App\Http\Requests\MahasiswaUpdateRequest;
use App\Http\Requests\ImportMahasiswaRequest;

use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

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
        $active         = 'active';
        
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
            'active'      => $active,
            'title'     => 'Data Mahasiswa Alumni'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createImport()
    {
        $prodi      =   ProgramStudi::get();
        
        return view ('admin.mahasiswa.formImport', [
            'prodi'     =>  $prodi,
            'title'     => 'Form Import Mahasiswa'
        ]);
    }

    /**
     * store import excel a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function import(ImportMahasiswaRequest $request)
     {
         try {
             $this->validate(
                 $request,
                 [
                     'file' => 'required|mimes:csv,xls,xlsx',
                 ],
                 [
                     'file.required' => 'File harus diisi',
                     'file.mimes:csv,xls,xlsx' => 'Format File Salah',
                 ]
             );
             
 
            //  import data
             $excel =  Excel::import(new MahasiswaImport($request->program_studi_id), $request->file('file'));
 
            if ($excel == null) {
                return redirect()->back()->with('error', "Failed Import Data..!!");;
            }
 
             return redirect()->route('mahasiswa.index')->withSuccess('Data Telah Berhasil Diimport!');
         } catch (\Throwable $th) {
             return redirect()->back()->with('error', "Failed Import Data..!!");;
         }
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodi    =   ProgramStudi::get();

        return view ('admin.mahasiswa.form', [
            'prodi'     =>  $prodi,
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
            $nomorWa = $request->input('wa');
            
            if (substr($nomorWa, 0, 1) === '0') {
                $wa = '62' . substr($nomorWa, 1);
            } else {
                $wa = 62 . $nomorWa;
            }

            $user = User::create([
                'name'        => $request->name,
                'nomor_induk' => $request->nomor_induk,
                'email'       => $request->email,
                'wa'          => $wa,
                'password'    => Hash::make($request->password),
                'email_verified_at' => now()
            ]);

            $data = [
                'user_id'           => $user->id,
                'nim'               => $user->nomor_induk,
                'angkatan'          => $request->angkatan,
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
                'status'        => $request->status
            ];


            $mahasiswa = Mahasiswa::create($data);
            
            if ($request->status == 'Alumni') {
                $user->assignRole('alumni');
            }elseif ($request->status == 'Mahasiswa Aktif'){
                $user->assignRole('mahasiswa');
            }else{

            }
            
            DB::commit();

            return redirect()->route('mahasiswa.index')->with('success', 'Data Berhasil Ditambah');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Mahasiswa Gagal Ditambah');
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
        $prodi = ProgramStudi::oldest('name')->get();

        return view ('admin.mahasiswa.detail', [
            'mahasiswa' => $mahasiswa,
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

        $mahasiswa = Mahasiswa::find($id);
        $prodi = ProgramStudi::oldest('name')->get();

        return view ('admin.mahasiswa.form', [
            'mahasiswa' => $mahasiswa,
            'prodi'     => $prodi,
            'title'     => 'Mahasiswa'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MahasiswaUpdateRequest $request, Mahasiswa $mahasiswa)
    {
        $nomorWa = $request->input('wa');
            
        if (substr($nomorWa, 0, 1) === '0') {
            $wa = '62' . substr($nomorWa, 1);
        } else {
            $wa = 62 . $nomorWa;
        }

        $data = [
            'nim'               => $request->nomor_induk,
            'angkatan'          => $request->angkatan,
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
            'status'        => $request->status,
        ];
        
        Mahasiswa::where('id', $mahasiswa->id)->update($data);

        $userData = [
            'name'        => $request->name,
            'nomor_induk' => $request->nomor_induk,
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
    
        User::whereId($mahasiswa->user_id)->update($userData);

        $user = User::where('id',$mahasiswa->user_id)->first();
        if ($request->status == 'Alumni') {
            $user->syncRoles('alumni');
        } elseif ($request->status == 'Mahasiswa Aktif') {
            $user->syncRoles('mahasiswa');
        } elseif ($request->status == 'Keluar') {
            // Menghapus role dari user
            $user->removeRole('alumni');
            $user->removeRole('mahasiswa');
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'angkatan'              => 'required',
        ], [
            'angkatan.required'     => 'Angkatan Wajib Diisi',
        ]);

        $checkAngkatan = Mahasiswa::where('angkatan', $request->angkatan)->get();

        if ($checkAngkatan->isEmpty()) {
            return redirect()->back()->with('error', 'Status Gagal Diubah');
        }

        $mahasiswa = Mahasiswa::where('angkatan', $request->angkatan)
        ->update([
            'status'            => 'Alumni',
        ]);

        $data = Mahasiswa::where('angkatan', $request->angkatan)->get();
        foreach ($data as $item) {
            $user = User::where('id', $item->user_id)->get();
            foreach ($user as $user) {
                $user->syncRoles('alumni');
            }
        }
        return redirect()->back()->with('success', 'Status Berhasil Diubah');
        
    }
}
