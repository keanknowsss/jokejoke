<?php


use App\Http\Controllers\FeedController;

use Illuminate\Support\Facades\Route;

Route::get('/', [FeedController::class, 'index']);
Route::view('/profile', 'profile');
Route::view('/sign-in', 'sign-in');
Route::view('/register', 'register');

