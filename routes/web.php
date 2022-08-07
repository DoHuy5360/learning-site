<?php

use App\Http\Controllers\Post_commentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Reply_commetController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostController::class, 'index']);

Route::resource('/post', PostController::class);
Route::resource('/comment', Post_commentController::class);
Route::resource('/reply', Reply_commetController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
