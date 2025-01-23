<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\POSController;
use Barryvdh\DomPDF\Facade\Pdf;


Route::get('/', [POSController::class, 'index'])->name('pos.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('products', ProductController::class);
Route::get('/products/mutasi/{id}', [ProductController::class, 'mutasi'])->name('products.mutasi');
Route::get('/home', [HomeController::class, 'index']);

Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
Route::get('/pos/pdf', [POSController::class, 'generatePdf']);
Route::post('/pos/transaction', [POSController::class, 'store'])->name('pos.store');
Route::get('/pos/laporan', [POSController::class, 'laporanTransaction'])->name('pos.laporan');
Route::get('/pos/laporan/{id}', [POSController::class, 'laporanTransactionDetail'])->name('pos.laporan_detail');

require __DIR__.'/auth.php';
