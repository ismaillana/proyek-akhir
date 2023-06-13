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
        
        if ($request->angkatan) {
            Mahasiswa::where('angkatan', $request->angkatan)
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

     public function import(Request $request)
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
 
            //  dd($excel);
            
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
