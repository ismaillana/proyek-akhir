<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AdminJurusanController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\IjazahController;
use App\Http\Controllers\KoorPklController;
use App\Http\Controllers\TempatPKLController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AktifKuliahController;
use App\Http\Controllers\IzinPenelitianController;
use App\Http\Controllers\JenisLegalisirController;
use App\Http\Controllers\LegalisirController;
use App\Http\Controllers\VerifikasiIjazahController;
use App\Http\Controllers\DispensasiController;
use App\Http\Controllers\PengantarPklController;
use App\Http\Controllers\BagianAkademikController;
use App\Http\Controllers\RiwayatController;



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
    return view('user.home',[
        'title' => 'Pengajuan Pelayanan Administrasi POLSUB'
    ]);
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
                'middleware'    => ['role:super-admin|bagian-akademik|admin-jurusan|koor-pkl'],
                'prefix'        => 'menu-admin'
            ],
            function () {
                Route::resource('jurusan', JurusanController::class);
                Route::resource('prodi', ProdiController::class);
                Route::resource('mahasiswa', MahasiswaController::class);
                Route::post('update-status/{$mahasiswa}', [MahasiswaController::class, 'updateStatus'])->name('update-status');
                Route::resource('jenis-legalisir', JenisLegalisirController::class);
                Route::resource('adminJurusan', AdminJurusanController::class);
                Route::resource('bagianAkademik', BagianAkademikController::class);
                Route::resource('instansi', InstansiController::class);
                Route::resource('ijazah', IjazahController::class);
                Route::resource('koorPkl', KoorPklController::class);
                Route::resource('tempat-pkl', TempatPKLController::class);
                Route::resource('manajemen-user', UserController::class);
                //Aktif Kuliah
                Route::resource('pengajuan-aktif-kuliah', AktifKuliahController::class);
                Route::post('tolak-aktif-kuliah/{id}', [AktifKuliahController::class, 'tolak'])->name('tolak-aktif-kuliah');
                Route::post('konfirmasi-aktif-kuliah/{id}', [AktifKuliahController::class, 'konfirmasi'])->name('konfirmasi-aktif-kuliah');
                Route::post('update-status-aktif-kuliah/{id}', [AktifKuliahController::class, 'updateStatus'])->name('update-status-aktif-kuliah');

                //Izin Penelitian
                Route::resource('pengajuan-izin-penelitian', IzinPenelitianController::class);
                Route::post('tolak-izin-penelitian/{id}', [IzinPenelitianController::class, 'tolak'])->name('tolak-izin-penelitian');
                Route::post('konfirmasi-izin-penelitian/{id}', [IzinPenelitianController::class, 'konfirmasi'])->name('konfirmasi-izin-penelitian');
                Route::post('update-status-izin-penelitian/{id}', [IzinPenelitianController::class, 'updateStatus'])->name('update-status-izin-penelitian');

                //Verifikasi Ijazah
                Route::resource('pengajuan-verifikasi-ijazah', VerifikasiIjazahController::class);
                Route::post('tolak-verifikasi-ijazah/{id}', [VerifikasiIjazahController::class, 'tolak'])->name('tolak-verifikasi-ijazah');
                Route::post('konfirmasi-verifikasi-ijazah/{id}', [VerifikasiIjazahController::class, 'konfirmasi'])->name('konfirmasi-verifikasi-ijazah');
                Route::post('update-status-verifikasi-ijazah/{id}', [VerifikasiIjazahController::class, 'updateStatus'])->name('update-status-verifikasi-ijazah');

                //Legalisir
                Route::resource('pengajuan-legalisir', LegalisirController::class);
                Route::post('tolak-legalisir/{id}', [LegalisirController::class, 'tolak'])->name('tolak-legalisir');
                Route::post('konfirmasi-legalisir/{id}', [LegalisirController::class, 'konfirmasi'])->name('konfirmasi-legalisir');
                Route::post('update-status-legalisir/{id}', [LegalisirController::class, 'updateStatus'])->name('update-status-legalisir');

                //Dispensasi
                Route::resource('pengajuan-dispensasi', DispensasiController::class);
                Route::post('tolak-dispensasi/{id}', [DispensasiController::class, 'tolak'])->name('tolak-dispensasi');
                Route::post('konfirmasi-dispensasi/{id}', [DispensasiController::class, 'konfirmasi'])->name('konfirmasi-dispensasi');
                Route::post('update-status-dispensasi/{id}', [DispensasiController::class, 'updateStatus'])->name('update-status-dispensasi');

                //Pengantar PKL
                Route::resource('pengajuan-pengantar-pkl', PengantarPklController::class);
                Route::post('tolak-pengantar-pkl/{id}', [PengantarPklController::class, 'tolak'])->name('tolak-pengantar-pkl');
                Route::post('konfirmasi-pengantar-pkl/{id}', [PengantarPklController::class, 'konfirmasi'])->name('konfirmasi-pengantar-pkl');
                Route::post('update-status-pengantar-pkl/{id}', [PengantarPklController::class, 'updateStatus'])->name('update-status-pengantar-pkl');

                Route::get('import-excel', [MahasiswaController::class, 'createImport'])->name('import-excel');
                Route::get('mahasiswa-prodi/{jurusan?}', [MahasiswaController::class, 'prodi'])->name('prodi');
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
                Route::resource('dispensasi', DispensasiController::class);
                Route::resource('pengantar-pkl', PengantarPklController::class);
                Route::get('riwayat-legalisir', [RiwayatController::class, 'index'])->name('riwayat-legalisir');
                Route::get('tracking-legalisir/{id}', [RiwayatController::class, 'tracking'])->name('tracking-legalisir');
            });
    });

});


