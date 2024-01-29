<?php

use App\Models\Pendaftar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\DaftarController;

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
    return view('beranda');
})->name('beranda');

Route::prefix('daftar')->group(function () {
    Route::get('/', [DaftarController::class, 'index'])->name('daftar');
    Route::post('/simpan', [DaftarController::class, 'store'])->name('daftar.store');
});

Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');

Route::get('/download/{filename}', [HasilController::class, 'download'])->name('download');

Route::get('/grafik', function () {
    // menghitung jumlah pendaftar berdasarkan beasiswa
    $hitungAkademis = Pendaftar::where('beasiswa', 'Beasiswa Akademis')->count();
    $hitungPrestasi = Pendaftar::where('beasiswa', 'Beasiswa Prestasi & Bakat')->count();
    $hitungRiset = Pendaftar::where('beasiswa', 'Beasiswa Riset & Penelitian')->count();
    // mengembalikan view grafik dengan mengirimkan data
    $data = [
        ['nama' => 'Beasiswa Akademis', 'jumlah' => $hitungAkademis],
        ['nama' => 'Beasiswa Prestasi & Bakat', 'jumlah' => $hitungPrestasi],
        ['nama' => 'Beasiswa Riset & Penelitian', 'jumlah' => $hitungRiset],
    ];
    return view('grafik',[
        'data' => $data,
    ]);
})->name('grafik');