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



Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return to_route('admin-login.form');
    });

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
        Route::get('sales-overview', AdminSalesOverviewController::class)
            ->name('sales-overview.index');
        Route::get('revenue-vs-profit', AdminRevenueVsProfitController::class)
            ->name('revenue-vs-profit.index');

        Route::prefix('inventory')->group(function () {
            Route::get('records', [AdminInventoryController::class, 'index'])->name('index.inventory');
            Route::post('records/store', [AdminInventoryController::class, 'store'])->name('store.inventory');
            Route::get('records/{productId}', [AdminInventoryController::class, 'show'])->name('get.inventory');
            Route::put('records/update', [AdminInventoryController::class, 'update'])->name('update.inventory');
            Route::delete('records/delete', [AdminInventoryController::class, 'destroy'])->name('delete.inventory');
            Route::get('deleted_product', [AdminInventoryController::class, 'restoreIndex'])->name('index.deleted.inventory');
            Route::post('restore', [AdminInventoryController::class, 'restore'])->name('restore.inventory');
            // STOCK-IN ROUTES
            Route::get('stock-in', [AdminProductInventoryStockInController::class, 'index'])->name('index.stock-in');
            Route::post('stock-in/store', [AdminProductInventoryStockInController::class, 'store'])->name('store.stock-in');
            Route::put('stock-in/update', [AdminProductInventoryStockInController::class, 'update'])->name('update.stock-in');
        });
    });

    // CATEGORY ROUTES
    Route::get('category/{categoryName}', [AdminCategoryController::class, 'index'])->name('index.category');
    Route::post('category/store', [AdminCategoryController::class, 'store'])->name('store.category');
    Route::get('category/{categoryId}', [AdminCategoryController::class, 'show'])->name('get.category');
    Route::put('category/update', [AdminCategoryController::class, 'update'])->name('update.category');
    Route::delete('category/delete', [AdminCategoryController::class, 'destroy'])->name('destroy.category');

    // SALES ROUTES
    Route::get('sales', [AdminSaleController::class, 'index'])->name('sales.index');
    Route::post('sales', [AdminSaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}', [AdminSaleController::class, 'show'])->name('sales.show');
    Route::get('sales/{sale}/edit', [AdminSaleController::class, 'edit'])->name('sales.edit');
    Route::patch('sales/{sale}', [AdminSaleController::class, 'update'])->name('sales.update');
    Route::delete('sales/{sale}', [AdminSaleController::class, 'destroy'])->name('sales.destroy');
    Route::patch('sales/{sale}/restore', AdminSaleRestoreController::class)->name('sales.restore');

    // QUICK SALES ROUTES
    Route::post('quick-sales', [AdminQuickSaleController::class, 'store'])->name('quick-sales.store');
    Route::delete('quick-sales/{quickSale}', [AdminQuickSaleController::class, 'destroy'])->name('quick-sales.destroy');
    Route::patch('quick-sales/{quickSale}/restore', AdminQuickSaleRestoreController::class)->name('quick-sales.restore');

    Route::get('deleted_sales', [AdminSaleController::class, 'restoreIndex'])->name('index.deleted.sales');
    Route::get('product_details/{productId}', [AdminSaleController::class, 'details'])->name('product.details');
    Route::get('supplier/{supplierName}', [AdminSupplierController::class, 'index'])->name('index.supplier');


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

});