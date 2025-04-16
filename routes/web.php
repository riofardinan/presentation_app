<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\DetailTutorialController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/presentation/{slug}', [DetailTutorialController::class, 'presentation'])->name('presentation');
Route::get('/finished/{slug}', [DetailTutorialController::class, 'finished'])->name('finished');
Route::get('/printpdf/{slug}', [DetailTutorialController::class, 'printPdf'])->name('printpdf');

Route::middleware(AuthMiddleware::class)->group(function () {
    // Master Tutorial
    Route::get('/tutorials', [TutorialController::class, 'index'])->name('tutorials.index');
    Route::post('/tutorials', [TutorialController::class, 'store'])->name('tutorials.store');
    Route::put('/tutorials/{tutorial}', [TutorialController::class, 'update'])->name('tutorials.update');
    Route::delete('/tutorials/{tutorial}', [TutorialController::class, 'destroy'])->name('tutorials.destroy');

    // Detail Tutorial
    Route::get('/tutorials/{slug}', [DetailTutorialController::class, 'index'])->name('details.index');
    Route::post('/tutorials/{slug}', [DetailTutorialController::class, 'store'])->name('details.store');
});