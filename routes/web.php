<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes(['verify' => 'true']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/community', [App\Http\Controllers\CommunityLinkController::class, 'index'])->name('community');

Route::post('/community', [App\Http\Controllers\CommunityLinkController::class, 'store'])
->middleware(['auth']);

Route::get('community/{channel:slug}', [App\Http\Controllers\CommunityLinkController::class, 'index']);
