<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;

use App\Livewire\Profile;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [FeedController::class, 'index'])->name('home');

Route::fallback(function () {
    return redirect()->route('home');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/sign-in', [AuthController::class, 'create'])
        ->name('user.sign-in');
    Route::post('/sign-in', [AuthController::class, 'store'])
        ->name('user.sign-in.store');

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('user.register.index');
    Route::post('/register', [RegisterController::class, 'store'])
        ->name('user.register.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{user_id}', Profile::class)->name('profile');

    Route::post('/logout', [AuthController::class, 'destroy'])
        ->name('user.logout');
});





Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');       // Clear application cache
    Artisan::call('config:clear');      // Clear config cache
    Artisan::call('config:cache');      // Rebuild config cache
    Artisan::call('route:clear');       // Clear route cache
    Artisan::call('route:cache');       // Rebuild route cache
    Artisan::call('view:clear');        // Clear compiled Blade views
    Artisan::call('event:clear');       // Clear event cache
    Artisan::call('clear-compiled');    // Clear compiled classes
    Artisan::call('queue:restart');     // Restart queue workers
    Artisan::call('optimize:clear');    // Clear optimized class cache

    return "All caches cleared, optimized files removed, and queue restarted successfully! 🚀";
});
