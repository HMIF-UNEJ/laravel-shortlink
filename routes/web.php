<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkController;

Route::get('/', function () {
    return redirect()->route('login');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::resource('dashboard', ShortLinkController::class)->middleware(['auth']);
Route::get('dashboard/{id}/delete', [ShortLinkController::class, 'destroy'])->name('hapus.link');

require __DIR__.'/auth.php';

Route::get('{code}', [ShortLinkController::class, 'shortenLink'])->name('shorten.link');
