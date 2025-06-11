<?php

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\PenjemputanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

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
    return view('landing');
})->name('landing');

// User Management Routes
Route::middleware(['auth', 'super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserManagementController::class)->except(['show']);
});

Route::get('/home', [FrontendController::class, 'index'])->name('frontend');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [JenisSampahController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/jenis_sampah/show', [JenisSampahController::class, 'show'])->name('jenis_sampah.show');
Route::get('/jenis_sampah/show/{id}', [JenisSampahController::class, 'showByid'])->name('jenis_sampah.show');
Route::post('/riwayat', [RiwayatController::class, 'store'])->name('riwayat.store');
Route::middleware('auth')->group(function () {
    Route::post('/jenis_sampah', [JenisSampahController::class, 'store'])->name('jenis_sampah.store');
    Route::patch('/jenis_sampah/edit', [JenisSampahController::class, 'update'])->name('jenis_sampah.update');
    Route::delete('/jenis_sampah/{id}', [JenisSampahController::class, 'destroy'])->name('jenis_sampah.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/riwayattransaksi', [RiwayatController::class, 'index'])->name('riwayat.transaksi');
});

Route::middleware(['auth', 'access_penjemputan'])->group(function () {
    Route::get('/admin/penjemputan', [PenjemputanController::class, 'index'])->name('penjemputan.index');
    Route::put('/admin/penjemputan/{id}', [PenjemputanController::class, 'update'])->name('penjemputan.update');
    Route::get('/admin/penjemputan/{id}/edit', [PenjemputanController::class, 'edit'])->name('penjemputan.edit');
    Route::delete('/admin/penjemputan/{id}', [PenjemputanController::class, 'destroy'])->name('penjemputan.destroy');
});
Route::middleware(['auth', 'access_penjemputan'])->group(function () {
    Route::post('/penjemputan', [PenjemputanController::class, 'store'])->name('penjemputan.store');
});

Route::get('/user/autocomplete', [TransaksiController::class, 'autocomplete'])->name('user.autocomplete');
Route::resource('transaksi', TransaksiController::class);

require __DIR__ . '/auth.php';
