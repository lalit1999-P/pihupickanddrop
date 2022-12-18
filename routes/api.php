<?php

use App\Http\Controllers\api\Api;
use App\Http\Controllers\api\AuthenticateController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\LocationController;
use App\Http\Controllers\api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', [AuthenticateController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    //vehicle model 
    Route::post('vehicle-model', [OrderController::class, 'vehicleModel']);
    Route::post('vehicle-variant', [OrderController::class, 'getVarient']);
    Route::post('/all-locations', [OrderController::class, 'getAllLocation']);
    Route::post('/place-order', [OrderController::class, 'placeOrder']);
    Route::post('/order-image', [OrderController::class, 'storeOrderImage']);
    Route::post('/order-history', [OrderController::class, 'orderHistory']);

    // old routes 
    Route::post('/all-categories', [CategoryController::class, 'allCategory']);
    Route::post('/location-price', [Api::class, 'location_price']);
    Route::get('/driver-orders', [OrderController::class, 'driver_orders']);
    Route::post('/change-order-status', [OrderController::class, 'changeorderstatus']);
    Route::post('/pickup-image', [OrderController::class, 'pickup_image']);
    Route::post('/dropoff-image', [Api::class, 'dropoff_image']);
    // Route::get('/order-history', [Api::class, 'order_history']);
    Route::post('/update-user-profile', [OrderController::class, 'update_user_profile']);
    Route::post('/daily-check', [OrderController::class, 'daily_check']);
    Route::post('/order-status', [Api::class, 'order_status']);
    Route::get('/view-profile', [AuthenticateController::class, 'view_profile']);
    Route::post('/change-password', [AuthenticateController::class, 'changePassword']);
});
Route::post('/send-otp', [AuthenticateController::class, 'send_otp']);
Route::post('/verify-otp', [AuthenticateController::class, 'verify_mail_otp']);
Route::post('forgot-password', [AuthenticateController::class, 'forgotPassword']);
