<?php

use App\Http\Controllers\searchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WallController;


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

Route::get('/dashboard', [WallController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/{name}', [WallController::class, 'profil'])->middleware(['auth'])->name('profil');

Route::get('/editProfil/{name}',
    [wallController::class,'editProfil']
)->middleware(['auth'])->name('editProfil');

Route::post('/updateProfil/{name}',
    [wallController::class,'updateProfil']
)->middleware(['auth'])->name('updateProfil');

Route::post('/search', [searchController::class, 'searchResult'])->middleware(['auth'])->name('search');

Route::post('/postMessage/{parentPost?}',
    [WallController::class,'postMessage']
)->middleware(['auth'])->name('postMessage');

Route::post('/follow/{user?}',
    [WallController::class,'follow']
)->middleware(['auth'])->name('follow');

Route::post('/unfollow/{user?}',
    [WallController::class,'unfollow']
)->middleware(['auth'])->name('unfollow');


Route::get('/postPage/{id}',
    [WallController::class,'postPage']
)->middleware(['auth'])->name('postPage');

Route::get('/deletePost/{id}',
    [wallController::class,'deletePost']
)->middleware(['auth'])->name('deletePost');

Route::get('/updatePost/{id}',
    [wallController::class,'updatePost']
)->middleware(['auth'])->name('updatePost');

Route::post('/updatePost/{id}',
    [wallController::class,'savePost']
)->middleware(['auth'])->name('savePost');

Route::get('/notif/{user}',[WallController::class, 'notif'])->middleware(['auth'])->name('notif');
