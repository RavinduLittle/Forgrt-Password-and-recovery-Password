<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotpasController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('forget-password', [ForgotpasController::class, 'showForgotpasForm'])->name('forget.pass.get');
Route::post('forget-password', [ForgotpasController::class, 'submitForgetPasswordForm'])->name('forget.pass.post');
Route::get('reset-password/{token}', [ForgotpasController::class,'showresPasForm'])->name('reset.password.get');
Route::post('reset-password',[ForgotpasController::class,'SubmitrespasForm'])->name('reset.password.post');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
