<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Instansi;


use App\Http\Requests\ProfilRequest;
use App\Http\Requests\PasswordRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ProfilController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function profil()
    {
        $user    =   auth()->user();
        
        return view ('admin.profil.index', [
            'user'   =>  $user,
            'title'     => 'Profil'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfil(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email,'  . $id,
            'nomor_induk'       => 'required|unique:users,nomor_induk,'  . $id,
            'wa'                => 'required',
        ], [
            'name.required'         => 'Nama Wajib Diisi',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'wa.numeric'            => 'No WhatsApp Harus Berupa Angka',
            'email.unique'          => 'Email Sudah Digunakan',
            'nomor_induk.unique'    => 'Nomor Induk Sudah Digunakan'
        ]);

        $nomorWa = $request->input('wa');
            
        if (substr($nomorWa, 0, 1) === '0') {
            $wa = '62' . substr($nomorWa, 1);
        } else {
            $wa = 62 . $nomorWa;
        }

        $data = [
            'name'        => $request->name,
            'wa'          => $wa,
            'nomor_induk' => $request->nomor_induk,
            'email'       => $request->email,
        ];

        $image = User::saveImage($request);

        if ($image) {
            $data['image'] = $image;

            User::deleteImage($id);
        }

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function password()
    {
        $user    =   auth()->user();
        
        return view ('admin.password.index', [
            'user'   =>  $user,
            'title'     => 'Password'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(PasswordRequest $request, $id)
    {
        $data = [
            'password'    => Hash::make($request->password)
        ];

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profilMahasiswa()
    {
        $user    =   auth()->user();
        
        return view ('user.profil.profil-mahasiswa', [
            'user'   =>  $user,
            'title'     => 'Profil'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfilMahasiswa(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'wa'   => 'required',
            'email'   => 'required',
        ], [
            'name.required' => 'Masukkan Nama',
            'wa.required'   => 'Masukkan No WhatsApp',
            'email.required'   => 'Masukkan Email',
        ]);

        $data = [
            'name'        => $request->name,
            'wa'          => 62 . $request->wa,
            'email'       => $request->email,
        ];

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profilInstansi()
    {
        $user    =   auth()->user();
        $instansi = Instansi::whereUserId($user->id)->first();
        
        return view ('user.profil.profil-instansi', [
            'user'      =>  $user,
            'instansi'  => $instansi,
            'title'     => 'Profil'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfilInstansi(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'wa'   => 'required',
            'email'   => 'required',
            'alamat'   => 'required',
        ], [
            'name.required' => 'Masukkan Nama',
            'wa.required'   => 'Masukkan No WhatsApp',
            'email.required'   => 'Masukkan Email',
            'alamat.required'   => 'Masukkan Alamat',
        ]);

        $data = [
            'name'        => $request->name,
            'wa'          => 62 . $request->wa,
            'email'       => $request->email,
        ];

        User::where('id', $id)->update($data);

        Instansi::where('user_id', $id)->update([
            'nama_perusahaan'   => $request->name,
            'alamat'            => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function passwordUser()
    {
        $user    =   auth()->user();
        
        return view ('user.profil.password', [
            'user'   =>  $user,
            'title'     => 'Password'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePasswordUser(PasswordRequest $request, $id)
    {
        $data = [
            'password'    => Hash::make($request->password)
        ];

        User::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Diedit');
    }
    
}
