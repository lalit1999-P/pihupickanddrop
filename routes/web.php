<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleVariantController;
use App\Models\VehicleVariant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// dd("hi");
// Route::get('/', function () {
//     // dd("dddd");
//     return view('auth.login');
// })->name('/');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login-check', [AuthController::class, 'login'])->name('login-check');
Route::get('forgot-passwords', [AuthController::class, 'viewForgotPassword'])->name('forgot-passwords');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');


Route::middleware(['auth'])->group(function () {

    Route::middleware('role:ROLE_SUPERADMIN|ROLE_EMPLOYEE')->group(function () {

        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('profile-view/{id}', [AuthController::class, 'profileView'])->name('profile-view');
        Route::post('profile-update', [AuthController::class, 'update'])->name('profile-update');
        Route::get('/', [DashboardController::class, 'index'])->name('/');
        Route::post("get-vehicle-verient", [VehicleVariantController::class, 'getVehicleVarient'])->name("get-vehicle-verient");

        Route::get('serviceorder', [ServiceOrderController::class, 'view'])->name('serviceorder');
        Route::post('ajax-serviceorder', [ServiceOrderController::class, 'index'])->name('ajax-serviceorder');
        Route::get('create-serviceorder', [ServiceOrderController::class, 'create'])->name('create-serviceorder');
        Route::get('edit-serviceorder/{id}', [ServiceOrderController::class, 'edit'])->name('edit-serviceorder');
        Route::post('store-serviceorder', [ServiceOrderController::class, 'store'])->name('store-serviceorder');
        Route::delete('delete-serviceorder/{id}', [ServiceOrderController::class, 'destroy'])->name('delete-serviceorder');
        Route::get('view-invoice-serviceorder/{id}', [ServiceOrderController::class, 'viewinvoice'])->name('view-invoice-serviceorder');
        Route::get('/export-serviceorder', [ServiceOrderController::class, 'export'])->name('export-serviceorder');
        Route::get('generate-invoice-pdf/{id}', [ServiceOrderController::class, 'generateInvoicePDF'])->name('generate-invoice-pdf');
        Route::post('save-invoice', [ServiceOrderController::class, 'saveinvoice'])->name('save-invoice');
    });
    Route::middleware('role:ROLE_SUPERADMIN')->group(function () {

        Route::get('users', [UserController::class, 'view'])->name('user');
        Route::post('ajax-users', [UserController::class, 'index'])->name('ajax-users');
        Route::get('create-users', [UserController::class, 'create'])->name('create-users');
        Route::get('change-user-password/{id}', [UserController::class, 'changePassword'])->name('change-password');
        Route::post('update-password', [UserController::class, 'updatePassword'])->name('update-password');
        Route::get('edit-users/{id}', [UserController::class, 'edit'])->name('edit-users');
        Route::post('store-users', [UserController::class, 'store'])->name('store-users');
        Route::delete('delete-users/{id}', [UserController::class, 'destroy'])->name('delete-users');
        Route::get('/export-users', [UserController::class, 'exportUsers'])->name('export-users');

        Route::get('employee', [EmployeeController::class, 'view'])->name('employee');
        Route::post('ajax-employee', [EmployeeController::class, 'index'])->name('ajax-employee');
        Route::get('create-employee', [EmployeeController::class, 'create'])->name('create-employee');
        Route::get('edit-employee/{id}', [EmployeeController::class, 'edit'])->name('edit-employee');
        Route::post('store-employee', [EmployeeController::class, 'store'])->name('store-employee');
        Route::delete('delete-employee/{id}', [EmployeeController::class, 'destroy'])->name('delete-employee');
        Route::get('/export-employee', [EmployeeController::class, 'export'])->name('export-employee');

        Route::get('category', [CategoryController::class, 'view'])->name('category');
        Route::post('ajax-category', [CategoryController::class, 'index'])->name('ajax-category');
        Route::get('create-category', [CategoryController::class, 'create'])->name('create-category');
        Route::get('edit-category/{id}', [CategoryController::class, 'edit'])->name('edit-category');
        Route::post('store-category', [CategoryController::class, 'store'])->name('store-category');
        Route::delete('delete-category/{id}', [CategoryController::class, 'destroy'])->name('delete-category');

        Route::get('subcategory', [SubCategoryController::class, 'view'])->name('subcategory');
        Route::post('ajax-subcategory', [SubCategoryController::class, 'index'])->name('ajax-subcategory');
        Route::get('create-subcategory', [SubCategoryController::class, 'create'])->name('create-subcategory');
        Route::get('edit-subcategory/{id}', [SubCategoryController::class, 'edit'])->name('edit-subcategory');
        Route::post('store-subcategory', [SubCategoryController::class, 'store'])->name('store-subcategory');
        Route::delete('delete-subcategory/{id}', [SubCategoryController::class, 'destroy'])->name('delete-subcategory');

        Route::get('vehicle-model', [VehicleModelController::class, 'view'])->name('vehicle-model');
        Route::post('ajax-vehicle-model', [VehicleModelController::class, 'index'])->name('ajax-vehicle-model');
        Route::get('create-vehicle-model', [VehicleModelController::class, 'create'])->name('create-vehicle-model');
        Route::get('edit-vehicle-model/{id}', [VehicleModelController::class, 'edit'])->name('edit-vehicle-model');
        Route::post('store-vehicle-model', [VehicleModelController::class, 'store'])->name('store-vehicle-model');
        Route::delete('delete-vehicle-model/{id}', [VehicleModelController::class, 'destroy'])->name('delete-vehicle-model');
        Route::get('/export-vehicle-model', [VehicleModelController::class, 'export'])->name('export-vehicle-model');

        Route::get('vehicle-variant', [VehicleVariantController::class, 'view'])->name('vehicle-variant');
        Route::post('ajax-vehicle-variant', [VehicleVariantController::class, 'index'])->name('ajax-vehicle-variant');
        Route::get('create-vehicle-variant', [VehicleVariantController::class, 'create'])->name('create-vehicle-variant');
        Route::get('edit-vehicle-variant/{id}', [VehicleVariantController::class, 'edit'])->name('edit-vehicle-variant');
        Route::post('store-vehicle-variant', [VehicleVariantController::class, 'store'])->name('store-vehicle-variant');
        Route::delete('delete-vehicle-variant/{id}', [VehicleVariantController::class, 'destroy'])->name('delete-vehicle-variant');
        Route::get('/export-vehicle-verient', [VehicleVariantController::class, 'export'])->name('export-vehicle-verient');
    });
});
