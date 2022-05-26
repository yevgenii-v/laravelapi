<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TicketStaffController;
use App\Http\Controllers\Api\TicketStaffMessagesController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TicketUserController;
use App\Http\Controllers\Api\TicketUserMessagesController;
use App\Http\Middleware\IsAdmin;
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

//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Control Panel (Staff: Admin & Support only)
Route::group(['prefix' => 'cp', 'middleware' => ['auth:sanctum', 'isStaff']], function () {
    Route::apiResource('users', UserController::class)
        ->only(['index', 'show', 'update', 'destroy']);
    Route::apiResource('tickets', TicketStaffController::class)
        ->only(['index', 'store', 'show', 'update', 'delete']);
    Route::apiResource('tickets.messages', TicketStaffMessagesController::class)
        ->only(['store', 'update', 'destroy']);

    Route::middleware(IsAdmin::class)->group(function () {
        Route::apiResource('sliders', SliderController::class)
            ->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::apiResource('sliders.images', ImageController::class)
            ->only(['index', 'store', 'show', 'update', 'destroy']);
    });
});

//Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::apiResource('profile', ProfileController::class)
        ->only(['update', 'destroy'])
        ->middleware('profile');
    Route::group(['middleware' => 'checkUserRole'], function () {
        Route::apiResource('tickets', TicketUserController::class)
            ->only(['index', 'store', 'show', 'update']);
        Route::apiResource('tickets.messages', TicketUserMessagesController::class)
            ->only(['store']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
