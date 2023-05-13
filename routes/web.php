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
    return view('admin.dashboard');
});

Route::prefix('menu-admin')->group(function () {
    Route::resource('jurusan', JurusanController::class);
    Route::resource('prodi', ProdiController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('alumni', AlumniController::class);
    Route::resource('admin-jurusan', AdminJurusanController::class);
    Route::resource('instansi', InstansiController::class);
    Route::resource('ijazah', IjazahController::class);
    Route::resource('koor-pkl', KoorPKLController::class);
    Route::resource('tempat-pkl', TempatPKLController::class);
    Route::resource('manajemen-user', UserController::class);
});
