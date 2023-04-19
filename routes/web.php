<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EaduanController;
use App\Http\Controllers\JPJinfo;
use App\Http\Controllers\JpjInfoTempController;
use App\Http\Controllers\JpjMobileApiController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SecCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::get('/', [App\Http\Controllers\HomeController::class, 'showLoginForm'])->name('login');
Route::post('/', [App\Http\Controllers\HomeController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
// with auth 
Route::view('/', 'home')->middleware(['auth:web']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
Route::get('/privasi', function () {
    return view('privasi');
});

Route::get('/pdf-check', [HomeController::class, 'pdfCheck']);

Route::get('/upupgambar', function () {
    return view('test_upload');
})->name('upupgambar');

Route::post('/hntrgmbr', [EaduanController::class, 'upld_images']);

Route::get('/semakidawam2', [AuthenticationController::class, 'semakIdAwam']);
Route::get('/semakidawam', [AuthenticationController::class, 'semakId']);

Route::get('/checkemail', [SecCheckController::class, 'checkemail']);

Route::get('/check123', [AuthenticationController::class, 'check123']);
Route::get('/kmkadu', [EaduanController::class, 'kmkadu']);

Route::get('/direktori', [JpjMobileApiController::class, 'direktori_jpj']);
Route::get('/checksajo', [EaduanController::class, 'checksajo']);

Route::get('/jpjinfo-api/apps/semakstatuslesen', [JpjMobileApiController::class, 'semakstatusbank']);
Route::get('/FAQ', [JpjMobileApiController::class, 'faq']);

//path jpjinfo ke controller myjpj

// Route::get('/jpjinfo-api/apps/semaknopendaftaran', [JpjMobileApiController::class, 'semakan_nombor_pendaftaran']);
Route::get('/jpjinfo-api/apps/semakstatuslesen', [JpjMobileApiController::class, 'semakan_tarikh_luput_lesen_memandu']);


Route::get('/semakstatusbank', [JPJinfo::class, 'semakstatusbank']);
Route::get('/semaksaman', [JPJinfo::class, 'semaksaman']);
Route::get('/semakan_tarikh_luput_lesen_kenderaan_motor', [JPJinfo::class, 'semakan_tarikh_luput_lesen_kenderaan_motor']);
Route::post('/jpjinfo-api/apps/semaknopendaftaran', [JPJinfo::class, 'semakan_nombor_pendaftaran']);
Route::get('/semakan_status_permohonan_penubuhan_institut_memandu', [JPJinfo::class, 'semakan_status_permohonan_penubuhan_institut_memandu']);
Route::get('/semakan_tarikh_luput_lesen_memandu', [JPJinfo::class, 'semakan_tarikh_luput_lesen_memandu']);
Route::get('/semakan_status_senarai_hitam', [JPJinfo::class, 'semakan_status_senarai_hitam']);
Route::get('/semakan_dimerit', [JPJinfo::class, 'semakan_dimerit']);
Route::get('/semakan_pertukaran_lesen_memandu_luar_negara', [JPJinfo::class, 'semakan_pertukaran_lesen_memandu_luar_negara']);
Route::get('/semakan_ujian_memandu', [JPJinfo::class, 'semakan_ujian_memandu']);
Route::get('/direktori', [JPJinfo::class, 'direktori_jpj']);


Route::post('/a', [JPJinfo::class, 'a']);




Route::post('/testnfs', [LogController::class, 'nfs']);
Route::get('/nfs', function () {
    return view('nfs');
});
require __DIR__ . '/auth.php';

Route::get('/checknfsget', [EaduanController::class, 'checkxyz']);
Route::get('/checkvideo', [EaduanController::class, 'tryvideo']);

Route::get('/aduantrafikmobile/client_share/{no_aduan}/{nama_file}', [EaduanController::class, 'gambar']);
Route::get('/aduantrafikmobile/client_share/{nama_file}', [EaduanController::class, 'gambar2']);
