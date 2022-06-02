<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TicketStaffController;
use App\Http\Controllers\Api\TicketStaffMessageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TicketUserController;
use App\Http\Controllers\Api\TicketUserMessageController;
use App\Http\Middleware\IsAdmin;
use App\Models\Category;
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
Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);
Route::apiResource('categories.products', ProductController::class)
    ->only(['index', 'show']);
Route::apiResource('products.reviews', ReviewController::class)
    ->only(['index', 'show']);

//Control Panel (Staff: Admin & Support only)
Route::group(['prefix' => 'cp', 'middleware' => ['auth:sanctum', 'isStaff']], function () {
    Route::apiResource('users', UserController::class)
        ->only(['index', 'show', 'update', 'destroy']);
    Route::apiResource('tickets', TicketStaffController::class)
        ->only(['index', 'store', 'show', 'update', 'delete']);
    Route::apiResource('tickets.messages', TicketStaffMessageController::class)
        ->only(['store', 'update', 'destroy']);

    Route::middleware(IsAdmin::class)->group(function () {
        Route::apiResource('sliders', SliderController::class)
            ->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::apiResource('sliders.images', ImageController::class)
            ->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::apiResource('categories', CategoryController::class)
            ->only(['store', 'update', 'destroy']);
        Route::apiResource('categories.products', ProductController::class)
            ->only(['store', 'update', 'destroy']);
        Route::apiResource('products.reviews', ReviewController::class)
            ->only(['update', 'destroy']);
    });
});

//Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::apiResource('profile', ProfileController::class)
        ->only(['update', 'destroy'])
        ->middleware('profile');
    Route::apiResource('products.reviews', ReviewController::class)
        ->only(['store']);
    Route::group(['middleware' => 'checkUserRole'], function () {
        Route::apiResource('tickets', TicketUserController::class)
            ->only(['index', 'store', 'show', 'update']);
        Route::apiResource('tickets.messages', TicketUserMessageController::class)
            ->only(['store']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
