<?php


use App\Http\Controllers\FeedController;
use App\Http\Controllers\RegisterController;

use Illuminate\Support\Facades\Route;

Route::get('/', [FeedController::class, 'index']);
Route::view('/profile', 'profile');
Route::view('/sign-in', 'sign-in');

Route::get('/register', [RegisterController::class, 'create']);

Route::view('/jokes', 'jokes');
