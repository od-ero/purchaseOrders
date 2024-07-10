<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});
Route::get('/livewire', function () {
    return view('livewirewelcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admins.dashboard');
})->middleware(['auth', 'verified'])->name('admins.dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users/register/neither', [RegisteredUserController::class, 'create'])
    ->name('register');
    Route::get('/multiple/users/register', [RegisteredUserController::class, 'mulCreate'])
    ->name('mulregister');

    Route::post('/register', [RegisteredUserController::class, 'store'])->name('postRegister');
    Route::get('/display/users', function () {
        return view('admins.displayUsers');
    });
});

require __DIR__.'/auth.php';
