<?php

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Api\v1\AuthController;
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

Route::middleware('check_api_key')->group(function () {

    Route::post('/v1/sports/type', [ApiController::class, 'sports_type']);
    Route::post('/v1/live_matches/{app_unique_id}', [ApiController::class, 'live_matches']);
    Route::post('/v1/live_matches_by_type/{app_unique_id}', [ApiController::class, 'live_matches_by_type']);
    Route::post('/v1/streaming_sources/{app_unique_id}/{match_id}', [ApiController::class, 'streaming_sources']);
    Route::post('/v1/highlights/{app_unique_id}', [ApiController::class, 'highlights']);
    Route::post('/v1/popular_series/{app_unique_id}', [ApiController::class, 'popular_series']);
    Route::post('/v1/settings/{app_unique_id}/{platform?}', [ApiController::class, 'settings']);

    // AuthController
    Route::post('/v1/signup', [AuthController::class, 'signup']);
    Route::post('/v1/signin', [AuthController::class, 'signin']);
    // Route::post('/v1/forget_password', [AuthController::class, 'forget_password']);

    Route::middleware('auth:sanctum')->group(function () {

        //AuthController
        Route::post('/v1/user', [AuthController::class, 'user']);
        Route::post('/v1/user_update', [AuthController::class, 'user_update']);
        Route::post('/v1/change_password', [AuthController::class, 'change_password']);

    });

});
