<?php

use App\Http\Controllers\BiodataController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BiodataController::class, 'index'])->name('home');
Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');
Route::put('/biodata/{biodata}', [BiodataController::class, 'update'])->name('biodata.update');
Route::delete('/biodata/{biodata}', [BiodataController::class, 'destroy'])->name('biodata.destroy');

Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/uts', 'uts')->name('uts');

// Alias untuk route batagor & tahu jika diperlukan
Route::get('/batagor', [BiodataController::class, 'index'])->name('batagor');
Route::view('/tahu', 'tentang')->name('tahu');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
