<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\RegisterController;

use Illuminate\Support\Facades\Route;

Route::get('/', [FeedController::class, 'index'])->name('home');
Route::view('/profile', 'profile')->name('profile');

Route::get('/sign-in', [AuthController::class, 'create'])->name('user.sign-in');
Route::post('/sign-in', [AuthController::class, 'store'])->name('user.sign-in.store');

Route::get('/register', [RegisterController::class, 'create'])->name('user.register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('user.register.store');

Route::post('/logout', [AuthController::class, 'destroy'])->name('user.logout');

Route::view('/jokes', 'jokes');
