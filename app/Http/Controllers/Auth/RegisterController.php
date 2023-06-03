<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Instansi;

use App\Http\Requests\RegisterRequest;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
    protected function register(RegisterRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = User::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'wa'          => 62 . $request->wa,
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

            return redirect()->route('login')->with('success', 'Silahkan Login.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError('Silahkakn Hubungi Admin');
        }
    }
}
