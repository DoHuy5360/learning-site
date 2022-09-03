<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Post_commentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Question_answerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Reply_answerController;
use App\Http\Controllers\Reply_commentController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TagController;
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
Route::resource('/profile', ProfileController::class);
Route::resource('/series', SeriesController::class);
Route::resource('/follow', FollowController::class);
Route::resource('/tag', TagController::class);
Route::resource('/bookmark', BookmarkController::class);

Route::get('/question-list/{index}', [QuestionController::class, 'getQuestions']);
Route::get('/post-relative/{tag}', [QuestionController::class, 'getRelativePost']);
Route::get('/post-list/{index}', [PostController::class, 'getPosts']);
Route::get('/post-comment/{id}/{index}', [Post_commentController::class, 'getComments']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
