<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AdminJurusanController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\IjazahController;
use App\Http\Controllers\KoorPKLController;
use App\Http\Controllers\TempatPKLController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AktifKuliahController;
use App\Http\Controllers\IzinPenelitianController;
use App\Http\Controllers\JenisLegalisirController;
use App\Http\Controllers\LegalisirController;
use App\Http\Controllers\VerifikasiIjazahController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user.home');
});
// Route::get('/', [HomeController::class, 'index'])->name('home');


//Prevent-Back
Route::group(['middleware' => 'prevent-back-history'],function(){
//Login
Auth::routes();

    Route::middleware('auth')->group(function () {
        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::group(
            [
                'middleware'    => ['role:bagian-akademik|admin-jurusan|koor-pkl'],
                'prefix'        => 'menu-admin'
            ],
            function () {
                Route::resource('jurusan', JurusanController::class);
                Route::resource('prodi', ProdiController::class);
                Route::resource('mahasiswa', MahasiswaController::class);
                Route::resource('jenis-legalisir', JenisLegalisirController::class);
                Route::resource('alumni', AlumniController::class);
                Route::resource('admin-jurusan', AdminJurusanController::class);
                Route::resource('instansi', InstansiController::class);
                Route::resource('ijazah', IjazahController::class);
                Route::resource('koor-pkl', KoorPKLController::class);
                Route::resource('tempat-pkl', TempatPKLController::class);
                Route::resource('manajemen-user', UserController::class);
                Route::resource('pengajuan-aktif-kuliah', AktifKuliahController::class);
                Route::resource('pengajuan-izin-penelitian', IzinPenelitianController::class);
        });
    });

    // Route::middleware(['role:alumni|mahasiswa|instansi'])->get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::middleware('auth')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        Route::group(
            [
                'middleware'    => ['role:alumni|mahasiswa|instansi'],
                'prefix'        => 'pengajuan'
            ],
            function () {
                Route::resource('aktif-kuliah', AktifKuliahController::class);
                Route::resource('izin-penelitian', IzinPenelitianController::class);
                Route::resource('legalisir', LegalisirController::class);
                Route::resource('verifikasi-ijazah', VerifikasiIjazahController::class);
        });
    });

});


