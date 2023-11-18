<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::resource('users', 'App\Http\Controllers\UserController')
    ->middleware(['auth', 'verified', 'admin']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/community', [App\Http\Controllers\CommunityLinkController::class, 'index'])
    ->name('community');

Route::post('/community', [App\Http\Controllers\CommunityLinkController::class, 'store'])
    ->middleware(['auth']);

Route::get('/community/{channel:slug}', [App\Http\Controllers\CommunityLinkController::class, 'index']);

Route::post('/votes/{link}', [App\Http\Controllers\CommunityLinkUserController::class, 'store'])
    ->middleware(['auth']);

Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])
    ->middleware(['auth'])->name('editprofile');

Route::post('/profile/store', [App\Http\Controllers\ProfileController::class, 'store'])
    ->middleware(['auth'])->name('storeprofile');
