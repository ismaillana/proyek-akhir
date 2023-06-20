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
use App\Http\Controllers\ProfilController;

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


//Prevent-Back
Route::group(['middleware' => 'prevent-back-history'],function(){
    
    Route::get('/', function () {
        return view('user.home',[
            'title' => 'Pengajuan Pelayanan Administrasi POLSUB'
        ]);
    });

    //Login
    Auth::routes();

    Route::middleware('auth')->group(function () {
        //Dashboard
        Route::middleware(['role:super-admin|bagian-akademik|admin-jurusan|koor-pkl'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::middleware(['role:super-admin|bagian-akademik|admin-jurusan|koor-pkl'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //Profil
        Route::middleware(['role:super-admin|bagian-akademik|admin-jurusan|koor-pkl'])->get('profil', [ProfilController::class, 'profil'])->name('profil');
        Route::post('update-profil/{update}', [ProfilController::class, 'updateProfil'])->name('update-profil');
        //Password
        Route::middleware(['role:super-admin|bagian-akademik|admin-jurusan|koor-pkl'])->get('password', [ProfilController::class, 'password'])->name('password');
        Route::post('update-password/{update}', [ProfilController::class, 'updatePassword'])->name('update-password');

        Route::group(
            [
                'middleware'    => ['role:super-admin'],
                'prefix'        => 'super-admin'
            ],
            function () {
                Route::resource('jurusan', JurusanController::class);
                Route::resource('prodi', ProdiController::class);
                Route::resource('adminJurusan', AdminJurusanController::class);
                Route::resource('bagianAkademik', BagianAkademikController::class);
        });

        Route::group(
            [
                'middleware'    => ['role:bagian-akademik|admin-jurusan|koor-pkl'],
                'prefix'        => 'menu-admin'
            ],
            function () {
                //Mahasiswa
                Route::resource('mahasiswa', MahasiswaController::class);
                Route::post('update-status/{$mahasiswa}', [MahasiswaController::class, 'updateStatus'])->name('update-status');
                //Instansi
                Route::resource('instansi', InstansiController::class);
                //koor-pkl
                Route::resource('koorPkl', KoorPklController::class);
                //tempat-pkl
                Route::resource('tempat-pkl', TempatPKLController::class);
                //Aktif Kuliah
                Route::resource('pengajuan-aktif-kuliah', AktifKuliahController::class);
                Route::post('tolak-aktif-kuliah/{id}', [AktifKuliahController::class, 'tolak'])->name('tolak-aktif-kuliah');
                Route::post('konfirmasi-aktif-kuliah/{id}', [AktifKuliahController::class, 'konfirmasi'])->name('konfirmasi-aktif-kuliah');
                Route::post('update-status-aktif-kuliah/{id}', [AktifKuliahController::class, 'updateStatus'])->name('update-status-aktif-kuliah');
                Route::get('riwayat-pengajuan-aktif-kuliah', [AktifKuliahController::class, 'riwayat'])->name('riwayat-pengajuan-aktif-kuliah');
                Route::get('riwayat-pengajuan-aktif-kuliah-detail/{id}', [AktifKuliahController::class, 'showRiwayat'])->name('riwayat-pengajuan-aktif-kuliah-detail');
                Route::get('export-aktif-kuliah', [AktifKuliahController::class, 'export'])->name('export-aktif-kuliah');

                //Izin Penelitian
                Route::resource('pengajuan-izin-penelitian', IzinPenelitianController::class);
                Route::post('tolak-izin-penelitian/{id}', [IzinPenelitianController::class, 'tolak'])->name('tolak-izin-penelitian');
                Route::post('konfirmasi-izin-penelitian/{id}', [IzinPenelitianController::class, 'konfirmasi'])->name('konfirmasi-izin-penelitian');
                Route::post('update-status-izin-penelitian/{id}', [IzinPenelitianController::class, 'updateStatus'])->name('update-status-izin-penelitian');
                Route::get('riwayat-pengajuan-izin-penelitian', [IzinPenelitianController::class, 'riwayat'])->name('riwayat-pengajuan-izin-penelitian');
                Route::get('riwayat-pengajuan-izin-penelitian-detail/{id}', [IzinPenelitianController::class, 'showRiwayat'])->name('riwayat-pengajuan-izin-penelitian-detail');
                Route::get('export-izin-penelitian', [IzinPenelitianController::class, 'export'])->name('export-izin-penelitian');

                //Verifikasi Ijazah
                Route::resource('pengajuan-verifikasi-ijazah', VerifikasiIjazahController::class);
                Route::post('tolak-verifikasi-ijazah/{id}', [VerifikasiIjazahController::class, 'tolak'])->name('tolak-verifikasi-ijazah');
                Route::post('konfirmasi-verifikasi-ijazah/{id}', [VerifikasiIjazahController::class, 'konfirmasi'])->name('konfirmasi-verifikasi-ijazah');
                Route::post('update-status-verifikasi-ijazah/{id}', [VerifikasiIjazahController::class, 'updateStatus'])->name('update-status-verifikasi-ijazah');
                Route::get('riwayat-pengajuan-verifikasi-ijazah', [VerifikasiIjazahController::class, 'riwayat'])->name('riwayat-pengajuan-verifikasi-ijazah');
                Route::get('riwayat-pengajuan-verifikasi-ijazah-detail/{id}', [VerifikasiIjazahController::class, 'showRiwayat'])->name('riwayat-pengajuan-verifikasi-ijazah-detail');
                Route::get('print-verifikasi-ijazah', [VerifikasiIjazahController::class, 'print'])->name('print-verifikasi-ijazah');
                Route::get('export-verifikasi-ijazah', [VerifikasiIjazahController::class, 'export'])->name('export-verifikasi-ijazah');

                //Legalisir
                Route::resource('pengajuan-legalisir', LegalisirController::class);
                Route::post('tolak-legalisir/{id}', [LegalisirController::class, 'tolak'])->name('tolak-legalisir');
                Route::post('konfirmasi-legalisir/{id}', [LegalisirController::class, 'konfirmasi'])->name('konfirmasi-legalisir');
                Route::post('update-status-legalisir/{id}', [LegalisirController::class, 'updateStatus'])->name('update-status-legalisir');
                Route::get('riwayat-pengajuan-legalisir', [LegalisirController::class, 'riwayat'])->name('riwayat-pengajuan-legalisir');
                Route::get('riwayat-pengajuan-legalisir-detail/{id}', [LegalisirController::class, 'showRiwayat'])->name('riwayat-pengajuan-legalisir-detail');
                Route::get('export-legalisir', [LegalisirController::class, 'export'])->name('export-legalisir');

                //Dispensasi
                Route::resource('pengajuan-dispensasi', DispensasiController::class);
                Route::post('tolak-dispensasi/{id}', [DispensasiController::class, 'tolak'])->name('tolak-dispensasi');
                Route::post('konfirmasi-dispensasi/{id}', [DispensasiController::class, 'konfirmasi'])->name('konfirmasi-dispensasi');
                Route::post('update-status-dispensasi/{id}', [DispensasiController::class, 'updateStatus'])->name('update-status-dispensasi');
                Route::get('riwayat-pengajuan-dispensasi', [DispensasiController::class, 'riwayat'])->name('riwayat-pengajuan-dispensasi');
                Route::get('riwayat-pengajuan-dispensasi-detail/{id}', [DispensasiController::class, 'showRiwayat'])->name('riwayat-pengajuan-dispensasi-detail');
                Route::get('export-dispensasi', [DispensasiController::class, 'export'])->name('export-dispensasi');

                //Pengantar PKL
                Route::resource('pengajuan-pengantar-pkl', PengantarPklController::class);
                Route::post('tolak-pengantar-pkl/{id}', [PengantarPklController::class, 'tolak'])->name('tolak-pengantar-pkl');
                Route::post('konfirmasi-pengantar-pkl/{id}', [PengantarPklController::class, 'konfirmasi'])->name('konfirmasi-pengantar-pkl');
                Route::post('review-pengantar-pkl/{id}', [PengantarPklController::class, 'review'])->name('review-pengantar-pkl');
                Route::post('update-status-pengantar-pkl/{id}', [PengantarPklController::class, 'updateStatus'])->name('update-status-pengantar-pkl');
                Route::get('riwayat-pengajuan-pengantar-pkl', [PengantarPklController::class, 'riwayat'])->name('riwayat-pengajuan-pengantar-pkl');
                Route::post('setuju-pengantar-pkl/{id}', [PengantarPklController::class, 'setuju'])->name('setuju-pengantar-pkl');
                Route::get('riwayat-pengajuan-pengantar-pkl-detail/{id}', [PengantarPklController::class, 'showRiwayat'])->name('riwayat-pengajuan-pengantar-pkl-detail');
                Route::get('export-pengantar-pkl', [PengantarPklController::class, 'export'])->name('export-pengantar-pkl');

                Route::get('import-excel', [MahasiswaController::class, 'createImport'])->name('import-excel');
                Route::post('import-excel-store', [MahasiswaController::class, 'import'])->name('import-excel-store');
                Route::get('mahasiswa-prodi/{jurusan?}', [MahasiswaController::class, 'prodi'])->name('prodi');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::middleware(['role:alumni|mahasiswa|instansi'])->get('/home', [HomeController::class, 'index'])->name('home');
        //Profil
        Route::middleware(['role:alumni|mahasiswa'])->get('profil-mahasiswa', [ProfilController::class, 'profilMahasiswa'])->name('profil-mahasiswa');
        Route::post('update-profil-mahasiswa/{update}', [ProfilController::class, 'updateProfilMahasiswa'])->name('update-profil-mahasiswa');
        
        Route::middleware(['role:instansi'])->get('profil-instansi', [ProfilController::class, 'profilInstansi'])->name('profil-instansi');
        Route::post('update-profil-instansi/{update}', [ProfilController::class, 'updateProfilInstansi'])->name('update-profil-instansi');
        //Password
        Route::middleware(['role:alumni|mahasiswa|instansi'])->get('password-user', [ProfilController::class, 'passwordUser'])->name('password-user');
        Route::post('update-password-user/{update}', [ProfilController::class, 'updatePasswordUser'])->name('update-password-user');

        Route::group(
            [
                'middleware'    => ['role:alumni'],
                'prefix'        => 'pengajuan',
                'as'            => 'pengajuan.'
            ],
            function () {
                //Legalisir
                Route::get('legalisir', [LegalisirController::class, 'create'])->name('legalisir.index');
                Route::post('legalisir', [LegalisirController::class, 'store'])->name('legalisir.store');
                Route::get('riwayat-legalisir', [RiwayatController::class, 'index'])->name('riwayat-legalisir');
                Route::get('tracking-legalisir/{id}', [RiwayatController::class, 'tracking'])->name('tracking-legalisir');
            }
        );

        Route::group(
            [
                'middleware'    => ['role:mahasiswa'],
                'prefix'        => 'pengajuan',
                'as'            => 'pengajuan.'
            ],
            function () {

                //Aktif-Kuliah
                Route::get('aktif-kuliah', [AktifKuliahController::class, 'create'])->name('aktif-kuliah.index');
                Route::post('aktif-kuliah', [AktifKuliahController::class, 'store'])->name('aktif-kuliah.store');
                Route::get('riwayat-aktif-kuliah', [RiwayatController::class, 'indexAktifKuliah'])->name('riwayat-aktif-kuliah');
                Route::get('tracking-aktif-kuliah/{id}', [RiwayatController::class, 'trackingAktifKuliah'])->name('tracking-aktif-kuliah');

                //Izin Penelitian
                Route::get('izin-penelitian', [IzinPenelitianController::class, 'create'])->name('izin-penelitian.index');
                Route::post('izin-penelitian', [IzinPenelitianController::class, 'store'])->name('izin-penelitian.store');
                Route::get('riwayat-izin-penelitian', [RiwayatController::class, 'indexIzinPenelitian'])->name('riwayat-izin-penelitian');
                Route::get('tracking-izin-penelitian/{id}', [RiwayatController::class, 'trackingIzinPenelitian'])->name('tracking-izin-penelitian');

                //Dispensasi
                Route::get('dispensasi', [DispensasiController::class, 'create'])->name('dispensasi.index');
                Route::post('dispensasi', [DispensasiController::class, 'store'])->name('dispensasi.store');
                Route::get('riwayat-dispensasi', [RiwayatController::class, 'indexDispensasi'])->name('riwayat-dispensasi');
                Route::get('tracking-dispensasi/{id}', [RiwayatController::class, 'trackingDispensasi'])->name('tracking-dispensasi');

                //PengantarPkl
                Route::get('pengantar-pkl', [PengantarPklController::class, 'create'])->name('pengantar-pkl.index');
                Route::post('pengantar-pkl', [PengantarPklController::class, 'store'])->name('pengantar-pkl.store');
                Route::get('riwayat-pengantar-pkl', [RiwayatController::class, 'indexPengantarPkl'])->name('riwayat-pengantar-pkl');
                Route::get('tracking-pengantar-pkl/{id}', [RiwayatController::class, 'trackingPengantarPkl'])->name('tracking-pengantar-pkl');
                Route::post('konfirmasi-terima/{id}', [RiwayatController::class, 'konfirmasi'])->name('konfirmasi-terima');
            }
        );

        Route::group(
            [
                'middleware'    => ['role:instansi'],
                'prefix'        => 'pengajuan',
                'as'            => 'pengajuan.'
            ],
            function () {
                //Verifikasi Ijazah
                Route::get('verifikasi-ijazah', [VerifikasiIjazahController::class, 'create'])->name('verifikasi-ijazah.index');
                Route::post('verifikasi-ijazah', [VerifikasiIjazahController::class, 'store'])->name('verifikasi-ijazah.store');
                Route::get('riwayat-verifikasi-ijazah', [RiwayatController::class, 'indexVerifikasiIjazah'])->name('riwayat-verifikasi-ijazah');
                Route::get('tracking-verifikasi-ijazah/{id}', [RiwayatController::class, 'trackingVerifikasiIjazah'])->name('tracking-verifikasi-ijazah');
            }
        );
    });

});


