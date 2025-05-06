<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssitanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ManageAccountController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminSaleController;
use App\Http\Controllers\CSWD\AssistanceController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminQuickSaleController;
use App\Http\Controllers\Admin\AdminSaleRestoreController;
use App\Http\Controllers\Admin\AdminSalesOverviewController;
use App\Http\Controllers\Admin\AdminRevenueVsProfitController;
use App\Http\Controllers\Admin\AdminQuickSaleRestoreController;
use App\Http\Controllers\Admin\AdminProductInventoryStockInController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\CSWD\ClientCategoryController;
use App\Models\ClientCategory;
use App\Models\Qualification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $datas = Qualification::all();
    return view('home', [
        'datas'=> $datas
    ]);
})->name('home');
Route::get('/header', function () {
    return view('header');
});

Route::middleware('guest')->group(function () {
    // Route::get('/', function () {
    //     return to_route('admin-login.form');
    // });

    // Auth Routes
    Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin-login.form');
    Route::post('admin/login', [LoginController::class, 'login'])->name('admin-login.submit');
});



Route::middleware('auth')->group(function () {
    // Auth Routes
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');


    //Admin Routes
    Route::prefix('admin')->group(function () {

        Route::get('dashboard', [AdminHomeController::class, 'index'])->name('index.home');
        Route::get('/category-data', [AdminHomeController::class, 'getCategoryData'])->name('getCategoryData.index');

        Route::get('barangay/{address}', [AdminHomeController::class, 'getBarangayAssistance'])->name('barangay.show');

        Route::get('sales-overview', AdminSalesOverviewController::class)
            ->name('sales-overview.index');
        Route::get('revenue-vs-profit', AdminRevenueVsProfitController::class)
            ->name('revenue-vs-profit.index');


    });

    // CATEGORY ROUTES
    Route::get('category/{categoryName}', [AdminCategoryController::class, 'index'])->name('index.category');
    Route::post('category/store', [AdminCategoryController::class, 'store'])->name('store.category');
    Route::get('category/{categoryId}', [AdminCategoryController::class, 'show'])->name('get.category');
    Route::put('category/update', [AdminCategoryController::class, 'update'])->name('update.category');
    Route::delete('category/delete', [AdminCategoryController::class, 'destroy'])->name('destroy.category');





    //Manage Accounts
    Route::controller(ManageAccountController::class)->group(function () {
        Route::get('manage_accounts', 'index')->name('admin.manage_account.index');
        Route::get('manage_account/{id}/show', 'show')->name('admin.manage_account.show');
        Route::get('manage_account/{id}/edit', 'edit')->name('admin.manage_account.edit');
        Route::post('manage_account/store', 'store')->name('admin.manage_account.store');
        Route::put('manage_account/update', 'update')->name('admin.manage_account.update');
        Route::delete('manage_account/delete', 'destroy')->name('admin.manage_account.destroy');
    });

    //Services Records
    Route::controller(AssitanceController::class)->group(function () {
        Route::get('services', 'index')->name('admin.service.index');
        Route::get('services/create', 'create')->name('admin.service.create');
        Route::post('services/store', 'store')->name('admin.service.store');
        Route::get('service/{id}', 'edit')->name('admin.service.edit');
        Route::get('service/{id}/show', 'show')->name('admin.service.show');
        Route::put('service', 'update')->name('admin.service.update');
        Route::delete('service/delete', 'destroy')->name('admin.service.destroy');
    });

    Route::post('save/assistance', [AssistanceController::class, 'store'])->name('store.save.assistance');

    Route::controller(AssistanceController::class)->group(function(){
        Route::get('assistances', 'index')->name('admin.assistance.index');
        Route::get('assistance/create', 'create')->name('admin.assistance.create');
        Route::post('assistance', 'store')->name('admin.assistance.storess');
        Route::get('assistances/{id}', 'edit')->name('admin.assistance.edit');
        Route::get('assistance/{id}/show', 'show')->name( 'admin.assistance.show');
        Route::get('assistance/{id}/getAssistantId', 'getAssistantId')->name( 'admin.assistance.getAssistantId');
        Route::get('assistance/{id}/getBarangayId', 'getBarangayId')->name( 'admin.assistance.getBarangayId');
        Route::put('assistance', 'update')->name('admin.assistance.update');
        Route::put('assistance/approved', 'approvedBarangay')->name('admin.assistance.approvedBarangay');
        Route::delete('assistance/delete', 'destroy')->name('admin.assistance.destroy');
    });

    //Services Records
    Route::controller(ClientCategoryController::class)->group(function () {
        Route::get('client-categories', 'index')->name('admin.client-categorie.index');
        Route::get('client-categories/create', 'create')->name('admin.client-categorie.create');
        Route::post('client-categories/store', 'store')->name('admin.client-categorie.store');
        Route::get('client-category/{id}', 'edit')->name('admin.client-category.edit');
        Route::get('client-category/{id}/show', 'show')->name('admin.client-category.show');
        Route::put('client-category', 'update')->name('admin.client-category.update');
        Route::delete('client-category/delete', 'destroy')->name('admin.client-category.destroy');
    });

    Route::controller(QualificationController::class)->group(function() {
        Route::get('/qualifications', 'index')->name('qualification.index');
        Route::post('/qualification', 'store')->name('qualification.store');
        Route::get('/qualification/{id}', 'show')->name('qualification.show');
        Route::put('/qualification', 'update')->name('qualification.update');
        Route::delete('/qualification', 'destroy')->name('qualification.destroy');
    });

});
