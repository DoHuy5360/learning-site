<?php

use App\Http\Controllers\Post_commentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Question_answerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Reply_answerController;
use App\Http\Controllers\Reply_commentController;
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
Route::resource('/post-comment', Post_commentController::class);
Route::resource('/reply-post', Reply_commentController::class);
Route::resource('/question', QuestionController::class);
Route::resource('/question-comment', Question_answerController::class);
Route::resource('/reply-answer', Reply_answerController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
