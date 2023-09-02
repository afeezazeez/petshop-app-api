<?php

use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\User\UserAuthController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function (): void {

    Route::group(['prefix' => 'admin'], function (): void {

        Route::post('login',[AuthController::class,'store']);
        Route::post('create',[AdminUserController::class,'store']);

        Route::middleware(['jwt'])->group(function () {

            Route::get('logout',[AuthController::class,'destroy']);
            Route::get('user-listing',[AdminUserController::class,'index']);
            Route::put('user-edit/{uuid}',[AdminUserController::class,'update']);
            Route::delete('user-delete/{uuid}',[AdminUserController::class,'destroy']);

        });

    });

    Route::group(['prefix' => 'user'], function (): void {
        Route::post('login',[UserAuthController::class,'store']);
        Route::post('create',[UserController::class,'store']);

        Route::middleware(['jwt'])->group(function () {

            Route::get('logout',[UserAuthController::class,'destroy']);

        });

    });

});
