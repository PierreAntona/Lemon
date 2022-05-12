<?php

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

Route::get('/{name}', function () {
    return view('profil');
})->middleware(['auth'])->name('profil');


Route::post('/postMessage',
    [WallController::class,'postMessage']
)->middleware(['auth'])->name('postMessage');
