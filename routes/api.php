<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\PropertyController;
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

Route::prefix('v1')
    ->group(function() {
        /** Users crud */
        Route::apiResource('users', UserController::class);

        /** Properties crud */
        Route::apiResource('properties', PropertyController::class);

        /** Get all properties by userid */
        Route::get('users/{id}/properties', [UserController::class, 'userProperties']);
    }
);
