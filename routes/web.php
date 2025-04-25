<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LoanController::class, 'index'])->name('dashboard');
    Route::view('/create', 'loan.create')->name('loan.calculate');
    Route::post('/processData', action: [LoanController::class, 'processData'])->name('processData');
    Route::get('/process_data_table', function () {
        return view('loan.process_data');
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
