<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\BusinessDetailsController;
use App\Http\Controllers\RolesAndPermissionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});
Route::get('/livewire', function () {
    return view('livewirewelcome');
});


Route::post('/employees/login', [AuthenticatedSessionController::class, 'store'])->name('employee.login');

Route::get('/dashboard', function () {
    return redirect()->intended('/admin/home');
})->middleware(['auth', 'verified'])->name('dashboard');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/admin/home', [HomeController::class, 'home'])->name('admins.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/employee/register', [RegisteredUserController::class, 'create'])
    ->name('register')->middleware('permission:add-employee');
    

    Route::post('/employee/register', [RegisteredUserController::class, 'store'])->name('postRegister')->middleware('permission:add-employee');
    // Route::get('/display/users', function () {
    //     return view('admins.displayUsers');
    // });

    Route::get('/employee/list-active', [EmployeesController::class, 'index'])
    ->name('employees.index')->middleware('permission:list-active-employee');

    Route::get('/employee/list-deleted', [EmployeesController::class, 'indexDeleted'])
    ->name('employees.indexDeleted')->middleware('permission:list-deleted-employee');
    Route::get('/employee/view/{id}', [EmployeesController::class, 'show'])
    ->name('employees.show')->middleware('permission:view-employee');

    Route::get('/employee/update/{id}', [EmployeesController::class, 'edit'])
    ->name('employees.edit')->middleware('permission:edit-employee');

    Route::post('/employee/update', [RegisteredUserController::class, 'update'])
    ->name('registeredUser.update')->middleware('permission:edit-employee');

    Route::get('/employee/delete/{id}', [RegisteredUserController::class, 'delete'])
    ->name('registeredUser.delete')->middleware('permission:destroy-employee');
    Route::get('/employee/activate/{id}', [RegisteredUserController::class, 'activate'])
    ->name('registeredUser.activate')->middleware('permission:activate-employee');
    Route::post('/import-and-view', [OrdersController::class, 'import'])
    ->name('orders.import')->middleware('permission:import-excel');
    Route::post('/save-and-view', [OrdersController::class, 'importAndView'])
    ->name('orders.saveAndView')->middleware('permission:import-excel');
    Route::get('/save-and-view', function () {
        return view('orders.view');
    })->name('view.table')->middleware('permission:import-excel');
    Route::get('/import', [OrdersController::class, 'importBlade'])
    ->name('import')->middleware('permission:import-excel');
    // Route::post('/import-and-save', [OrdersController::class, 'importAndView'])
    // ->name('orders.importAndSave');

   
    Route::get('/import-and-view', [OrdersController::class, 'importView'])
    ->name('orders.import_and_view_blade')->middleware('permission:import-excel');

    Route::get('/view/batch/{id}', [OrdersController::class, 'viewBatch'])
    ->name('orders.viewBatch')->middleware('permission:view-order');

    Route::get('/orders/pdf/{id}', [OrdersController::class, 'previewOrderasPdf'])
    ->name('orders.previewOrderasPdf')->middleware('permission:view-pdf');

    Route::get('/orders/no-cost-pdf/{id}', [OrdersController::class, 'noCostPDF'])
    ->name('orders.noCostPDF')->middleware('permission:view-pdf');

    Route::get('/make-orders/{id}', [OrdersController::class, 'makeOrder'])
    ->name('orders.makeOrder')->middleware('permission:send-order');
    Route::post('/make-orders', [OrdersController::class, 'sendOrder'])
    ->name('orders.sendOrder')->middleware('permission:send-order');

    Route::get('/orders/list-imported-batches', [OrdersController::class, 'listImportedOrders'])
    ->name('orders.listImportedOrders')->middleware('permission:list-imported-batch');

    Route::get('/orders/list-ordered-batches', [OrdersController::class, 'listOrderedOrders'])
    ->name('orders.listOrderedOrders')->middleware('permission:list-send-batch');

    Route::get('/update/batch/{id}', [OrdersController::class, 'editBatch'])
    ->name('orders.editBatch')->middleware('permission:edit-order');

    Route::post('/orders/update-batch', [OrdersController::class, 'updateBatch'])
    ->name('orders.updateBatch')->middleware('permission:edit-order');

    Route::get('/order-batch/delete/{id}', [OrdersController::class, 'deleteOrderBatch'])
    ->name('orders.deleteOrderBatch')->middleware('permission:destroy-order');

    Route::get('/order-batch/view-order-mail-content/{id}', [OrdersController::class, 'viewOrderMailContent'])
    ->name('orders.viewOrderMailContent')->middleware('permission:view-email-content');

    Route::get('/create-supplier', function () {
        return view('suppliers.create_supplier');
    })->name('suppliers.create_supplier')->middleware('permission:add-supplier');
    
    Route::post('/supplier/create', [SuppliersController::class, 'createSupplier'])
        ->name('suppliers.createSupplier')->middleware('permission:add-supplier');

        Route::get('/suppliers/list-active', [SuppliersController::class, 'listActiveSuppliers'])
        ->name('suppliers.listActiveSuppliers')->middleware('permission:list-active-supplier');

        Route::get('/suppliers/list-deleted', [SuppliersController::class, 'listDeletedSuppliers'])
        ->name('suppliers.listDeletedSuppliers')->middleware('permission:list-deleted-supplier');

        Route::get('/suppliers/view/{id}', [suppliersController::class, 'viewSupplier'])
        ->name('suppliers.viewSupplier')->middleware('permission:view-supplier');
        
        Route::get('/suppliers/update/{id}', [suppliersController::class, 'editSupplier'])
        ->name('suppliers.editSupplier')->middleware('permission:edit-supplier');

        Route::post('/supplier/update', [suppliersController::class, 'updateSupplier'])
        ->name('suppliers.updateSupplier')->middleware('permission:edit-supplier');

        Route::get('/supplier/delete/{id}', [suppliersController::class, 'deleteSupplier'])
    ->name('suppliers.deleteSupplier')->middleware('permission:destroy-supplier');

        Route::get('/supplier/activate/{id}', [suppliersController::class, 'activateSupplier'])
    ->name('suppliers.activateSupplier')->middleware('permission:activate-supplier');

    Route::get('/business-details', [BusinessDetailsController::class, 'businessDetails'])
            ->name('business_details.businessDetails')->middleware('permission:view-letter-head');

        Route::post('/update/business-details', [BusinessDetailsController::class, 'updateBusinessDetails'])
        ->name('business_details.updateBusinessDetails')->middleware('permission:edit-letter-head');
    
        Route::get('/system-name', [BusinessDetailsController::class, 'systemBusinessName'])
        ->name('business_details.systemBusinessName')->middleware('permission:system-name');

        Route::post('/system-name/update', [BusinessDetailsController::class, 'updateSystemBusinessName'])
        ->name('business_details.UpdateSystemBusinessName')->middleware('permission:edit-system-name');

        Route::get('/email-content', [BusinessDetailsController::class, 'emailContent'])
        ->name('business_details.email_content')->middleware('permission:view-email-content');

        Route::post('/email-content/update', [BusinessDetailsController::class, 'updateEmailContent'])
        ->name('business_details.updateEmailContent')->middleware('permission:edit-email-content');

        Route::get('/add-permissions', [RolesAndPermissionsController::class, 'addPermissions'])
        ->name('r_p.addPermissions');
        Route::get('/add-roles', [RolesAndPermissionsController::class, 'addRoles'])
        ->name('r_p.addRoles');

        Route::get('/create-roles', [RolesAndPermissionsController::class, 'createRoles'])
        ->name('r_p.createRoles')->middleware('permission:create-role');

        Route::get('/list-roles', [RolesAndPermissionsController::class, 'listRoles'])
        ->name('r_p.listRoles')->middleware('permission:list-role');

        Route::post('/store-roles', [RolesAndPermissionsController::class, 'storeRoles'])
        ->name('r_p.storeRoles')->middleware('permission:create-role');

        Route::get('/show-role/{id}', [RolesAndPermissionsController::class, 'showRole'])
        ->name('r_p.showRole')->middleware('permission:view-role');

        Route::get('/create-permission', [RolesAndPermissionsController::class, 'createPermission'])
        ->name('r_p.createpermission');

        Route::post('/store-permissions', [RolesAndPermissionsController::class, 'storePermissions'])
        ->name('r_p.storepermissions');

        Route::get('/edit-role/{id}', [RolesAndPermissionsController::class, 'editRole'])
        ->name('r_p.editRole')->middleware('permission:edit-role');

        Route::post('/update-role', [RolesAndPermissionsController::class, 'updateRole'])
        ->name('r_p.updateRole')->middleware('permission:edit-role');

        Route::get('/delete-role/{id}', [RolesAndPermissionsController::class, 'destroyRole'])
        ->name('r_p.deleteRole')->middleware('permission:destroy-role');

        Route::get('/edit-permission-level/{id}', [RolesAndPermissionsController::class, 'editPermissionLevel'])
        ->name('r_p.editPermissionLevel')->middleware('permission:edit-employee-role');

        Route::post('/update-permission-level', [RolesAndPermissionsController::class, 'updatePermissionLevel'])
        ->name('r_p.UpdatePermissionLevel')->middleware('permission:edit-employee-role');



       
    


});





require __DIR__.'/auth.php';
