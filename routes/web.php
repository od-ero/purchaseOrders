<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\BusinessDetailsController;
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
    Route::post('/import-and-view', [OrdersController::class, 'import'])
    ->name('orders.import');
    Route::post('/save-and-view', [OrdersController::class, 'importAndView'])
    ->name('orders.saveAndView');
    Route::get('/save-and-view', function () {
        return view('orders.view');
    })->name('view.table');
    Route::get('/import', function () {
        return view('orders.import');
    })->name('import');
    // Route::post('/import-and-save', [OrdersController::class, 'importAndView'])
    // ->name('orders.importAndSave');

   
    Route::get('/import-and-view', [OrdersController::class, 'importView'])
    ->name('orders.import_and_view_blade');

    Route::get('/view/batch/{id}', [OrdersController::class, 'viewBatch'])
    ->name('orders.viewBatch');

    Route::get('/orders/pdf/{id}', [OrdersController::class, 'previewOrderasPdf'])
    ->name('orders.previewOrderasPdf');

    Route::get('/orders/no-cost-pdf/{id}', [OrdersController::class, 'noCostPDF'])
    ->name('orders.noCostPDF');

    Route::get('/make-orders/{id}', [OrdersController::class, 'makeOrder'])
    ->name('orders.makeOrder');
    Route::post('/make-orders', [OrdersController::class, 'sendOrder'])
    ->name('orders.sendOrder');

    Route::get('/orders/list-imported-batches', [OrdersController::class, 'listImportedOrders'])
    ->name('orders.listImportedOrders');

    Route::get('/orders/list-ordered-batches', [OrdersController::class, 'listOrderedOrders'])
    ->name('orders.listOrderedOrders');

    Route::get('/update/batch/{id}', [OrdersController::class, 'editBatch'])
    ->name('orders.editBatch');

    Route::post('/orders/update-batch', [OrdersController::class, 'updateBatch'])
    ->name('orders.updateBatch');

    Route::get('/order-batch/delete/{id}', [OrdersController::class, 'deleteOrderBatch'])
    ->name('orders.deleteOrderBatch');

    Route::get('/order-batch/view-order-mail-content/{id}', [OrdersController::class, 'viewOrderMailContent'])
    ->name('orders.viewOrderMailContent');

    Route::get('/create-supplier', function () {
        return view('suppliers.create_supplier');
    })->name('suppliers.create_supplier');
    
    Route::post('/supplier/create', [SuppliersController::class, 'createSupplier'])
        ->name('suppliers.createSupplier');

        Route::get('/suppliers/list-active', [SuppliersController::class, 'listActiveSuppliers'])
        ->name('suppliers.listActiveSuppliers');

        Route::get('/suppliers/list-deleted', [SuppliersController::class, 'listDeletedSuppliers'])
        ->name('suppliers.listDeletedSuppliers');

        Route::get('/suppliers/view/{id}', [suppliersController::class, 'viewSupplier'])
        ->name('suppliers.viewSupplier');
        
        Route::get('/suppliers/update/{id}', [suppliersController::class, 'editSupplier'])
        ->name('suppliers.editSupplier');

        Route::post('/supplier/update', [suppliersController::class, 'updateSupplier'])
        ->name('suppliers.updateSupplier');

        Route::get('/supplier/delete/{id}', [suppliersController::class, 'deleteSupplier'])
    ->name('suppliers.deleteSupplier');

        Route::get('/supplier/activate/{id}', [suppliersController::class, 'activateSupplier'])
    ->name('suppliers.activateSupplier');

    Route::get('/business-details', [BusinessDetailsController::class, 'businessDetails'])
            ->name('business_details.editBusinessDetails');

        Route::post('/update/business-details', [BusinessDetailsController::class, 'updateBusinessDetails'])
        ->name('business_details.updateBusinessDetails');
    
        Route::get('/system-name', [BusinessDetailsController::class, 'systemBusinessName'])
        ->name('business_details.systemBusinessName');

        Route::post('/system-name/update', [BusinessDetailsController::class, 'updateSystemBusinessName'])
        ->name('business_details.UpdateSystemBusinessName');

        Route::get('/email-content', [BusinessDetailsController::class, 'emailContent'])
        ->name('business_details.email_content');

        Route::post('/email-content/update', [BusinessDetailsController::class, 'updateEmailContent'])
        ->name('business_details.updateEmailContent');
    


});





require __DIR__.'/auth.php';
