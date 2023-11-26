<?php

use App\Http\Controllers\Api\V1\CommunityLinkController;
use App\Http\Controllers\Api\V1\LoginController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('v1/communitylinks', CommunityLinkController::class)->middleware('api');

Route::post('v1/communitylinks/login', [LoginController::class, 'login'])->middleware('api');
