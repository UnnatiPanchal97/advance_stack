<?php
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::resource('/question',QuestionController::class);
// Route::resource('/tag',TagController::class);
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/question', QuestionController::class);
    Route::get('/questions/votes/{id?}', [App\Http\Controllers\QuestionController::class,'questionCastVote'])->name('question.votes');
    Route::get('/answers/votes/{id?}', [QuestionController::class, 'answerCastVote'])->name('answers.votes');
    Route::post('vote-up/{uptype}/{qid}', [QuestionController::class, 'question-up']);
    Route::post('vote-down/{uptype}/{qid}', [QuestionController::class, 'question-down']);
    Route::resource('/tag', TagController::class);
    Route::post('/store', [AnswerController::class, 'storeAnswer'])->name('submit');
    Route::get('/answers/{id}/edit', [AnswerController::class, 'editAnswer'])->name('answers');
    Route::post('accept-answer/{id}', [AnswerController::class, 'acceptAnswer'])->name('accept-answer');
    Route::put('/answersupdate/{id}', [AnswerController::class, 'updateAnswer'])->name('answers-update');
    Route::delete('/deleteanswer/{id}', [AnswerController::class, 'answerDelete'])->name('delete-answer');
});
