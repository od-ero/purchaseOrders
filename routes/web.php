<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});
Route::get('/livewire', function () {
    return view('livewirewelcome');
});
Route::post('/employees/login', [AuthenticatedSessionController::class, 'store'])->name('employee.login');

Route::get('/dashboard', function () {
    return redirect('/admin/home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/home', function () {
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

    Route::get('/employee/list-active', [EmployeesController::class, 'index'])
    ->name('employees.index');

    Route::get('/employee/list-deleted', [EmployeesController::class, 'indexDeleted'])
    ->name('employees.indexDeleted');
    Route::get('/employee/view/{id}', [EmployeesController::class, 'show'])
    ->name('employees.show');

    Route::get('/employee/update/{id}', [EmployeesController::class, 'edit'])
    ->name('employees.edit');

    Route::post('/employee/update', [RegisteredUserController::class, 'update'])
    ->name('registeredUser.update');

    Route::get('/employee/delete/{id}', [RegisteredUserController::class, 'delete'])
    ->name('registeredUser.delete');
    Route::get('/employee/activate/{id}', [RegisteredUserController::class, 'activate'])
    ->name('registeredUser.activate');
    Route::post('/test', [OrdersController::class, 'import'])
    ->name('orders.import');
    Route::post('/import-and-view', [OrdersController::class, 'importAndView'])
    ->name('orders.importAndView');

    Route::get('/import-and-view', function () {
        return view('orders.import');
    })->name('orders.import');

});





require __DIR__.'/auth.php';
