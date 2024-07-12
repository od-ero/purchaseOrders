<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});
Route::get('/livewire', function () {
    return view('livewirewelcome');
});
Route::post('/employees/login', [AuthenticatedSessionController::class, 'store'])->name('employee.login');

Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admins.dashboard');
})->middleware(['auth', 'verified'])->name('admins.dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/employee/register', [RegisteredUserController::class, 'create'])
    ->name('register');
    

    Route::post('/employee/register', [RegisteredUserController::class, 'store'])->name('postRegister');
    Route::get('/display/users', function () {
        return view('admins.displayUsers');
    });

    Route::get('/employee/view', [EmployeesController::class, 'index'])
    ->name('employees.index');

});

require __DIR__.'/auth.php';
