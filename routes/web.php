<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NetworkController;
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


Route::middleware('auth')->group(function () {
    Route::get('/', [NetworkController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [NetworkController::class, 'index']);
    Route::get('/networks/create', [NetworkController::class, 'create']);
    Route::post('/networks/create', [NetworkController::class, 'proceed']);
    Route::get('/networks/{network}', [NetworkController::class ,'show']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
