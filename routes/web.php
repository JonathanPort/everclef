<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\RepertoireController;
use App\Http\Controllers\CoverController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\SetListController;
use App\Http\Controllers\DevController;

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


if (env('APP_ENV') === 'local') {

    Route::get('/playground', [DevController::class, 'playground']);

}

Route::prefix('/repertoire')->group(function () {

    Route::get('/', [RepertoireController::class, 'index'])->name('repertoire');

});

Route::prefix('/covers')->group(function () {

    Route::get('/', [CoverController::class, 'index'])->name('covers');

    Route::get('/add', [CoverController::class, 'showCreateView'])->name('cover.create');
    Route::post('/create', [CoverController::class, 'create'])->name('cover.create.submit');

    Route::get('/edit/{cover}', [CoverController::class, 'showEditView'])->name('cover.edit');
    Route::post('/edit/{cover}', [CoverController::class, 'edit'])->name('cover.edit.submit');

    Route::get('/delete/{cover}', [CoverController::class, 'delete'])->name('cover.delete');

    Route::get('/lyrics-search', [CoverController::class, 'lyricsSearch']);

    Route::get('/get-lyrics', [CoverController::class, 'getLyrics']);

    Route::get('/{cover}', [CoverController::class, 'showCoverView'])->name('cover.show');

});

Route::prefix('/tags')->group(function () {

    Route::get('/', [TagsController::class, 'index'])->name('tags');

    Route::get('/edit/{tag}', [TagsController::class, 'showEditView'])->name('tag.edit');
    Route::post('/edit/{tag}', [TagsController::class, 'edit'])->name('tag.edit.submit');

    Route::get('/delete/{tag}', [TagsController::class, 'delete'])->name('tag.delete');

});


Route::prefix('/set-lists')->group(function () {

    Route::get('/', [SetListController::class, 'index'])->name('set-lists');

    Route::post('/create', [SetListController::class, 'create'])->name('set-list.create');

    Route::post('/update/{setList}', [SetListController::class, 'update'])->name('set-list.update');

    Route::get('/{setList}', [SetListController::class, 'show'])->name('set-lists.show');

    Route::get('/delete/{setList}', [SetListController::class, 'delete'])->name('set-list.delete');

});



Auth::routes();

Route::get('social-auth/{provider}/{type}', [SocialAuthController::class, 'redirectToProvider'])
     ->where([
        'provider' => '(facebook|google|sign-in-with-apple)',
        'type' => '(login|register)',
     ])
     ->name('social-auth');

Route::get('social-auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
