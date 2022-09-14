<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\AnonymousLoginController;
use App\Http\Controllers\RestaurantCategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::resource('tutorials', TutorialController::class)->only('index');

    Route::prefix('/users')->group(function () {
        Route::post('login', [LoginController::class, 'login']);
        Route::post('anonymous-login', AnonymousLoginController::class);
        Route::post('verify', [LoginController::class, 'verify']);
        Route::post('resend', [LoginController::class, 'resend']);

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('logout', [LoginController::class, 'logout']);
            Route::put('update-device-token', [LoginController::class, 'updateDeviceToken']);
            Route::resource('locations', LocationController::class);
        });

    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('restaurants', RestaurantController::class);
        Route::resource('restaurants.categories', RestaurantCategoryController::class)->only('index', 'show');
        Route::resource('offers', OfferController::class)->only('index');
    });
});
