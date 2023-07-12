<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Instansi;

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $request)
    {
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',
            'wa'                => 'required|numeric',
            'alamat'            => 'required',
            'password'          => 'required|min:3',
            'password_confirmation' => 'required|min:3|same:password'
        ], [
            'name.required'         => 'Nama Instansi Wajib Diisi',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'alamat.required'       => 'Alamat Wajib Diisi',
            'email.unique'          => 'Email Sudah Digunakan',
            'wa.numeric'            => 'No WhatsApp Harus Berupa Angka',
            'password.required'     => 'Password Wajib Diisi',
            'password.min'          => 'Password minimal 3 huruf/angka',
            'password_confirmation.required'=> 'Konfirmasi Password Wajib Diisi',
            'password_confirmation.min'     => 'Konfirmasi Password minimal 3 huruf/angka',
            'password_confirmation.same'    => 'Data Password dan Konfirmasi Password Harus Sama',
        ]);

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
                'password'    => Hash::make($request->password)
            ]);

            $user->assignRole('instansi');

            $data = [
                'user_id'           => $user->id,
                'nama_perusahaan'   => $user->name,
                'alamat'            => $request->alamat,
            ];

            $instansi = Instansi::create($data);

            event(new Registered($user));
            DB::commit();

            return redirect()->route('login')->with('success', 'Segera Lakukan Verifikasi Email!');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Silahkakn Hubungi Admin');
        }
    }
}
