<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    dd(\Auth::user());
})->name('home');

Auth::routes();

Route::get('social-auth/{provider}/{type}', [SocialAuthController::class, 'redirectToProvider'])
     ->where([
        'provider' => '(facebook|google|sign-in-with-apple)',
        'type' => '(login|register)',
     ])
     ->name('social-auth');

Route::get('social-auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
