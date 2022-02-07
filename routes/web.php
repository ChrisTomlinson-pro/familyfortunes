<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\DashboardController;

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
    return redirect('login');
});

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth'])->name('dashboard');

//Route::middleware('auth')->group(function() {
Route::middleware([])->group(function() {

    Route::get('admin-home', [QuizController::class, 'index'])->name('admin-home');

    /**
     * Prefix: 'quiz'
     */
    Route::prefix('quiz')->group(function() {
        Route::get('begin-broadcast/{quiz:uuid}', [QuizController::class, 'beginBroadcast'])->name('begin-broadcast');
        Route::get('create', [QuizController::class, 'create'])->name('quiz-create');
        Route::post('store', [QuizController::class, 'store'])->name('quiz-store');
        Route::get('show/{quiz:uuid}', [QuizController::class, 'show'])->name('quiz-show');
        Route::delete('delete/{quiz:uuid}', [QuizController::class, 'destroy'])->name('quiz-delete');
    });

    /**
     * Prefix: 'question'
     */
    Route::prefix('question')->group(function() {
        Route::post('store/{quiz:uuid}', [QuestionController::class, 'store'])->name('question-store');
        Route::post('update/{question:uuid}', [QuestionController::class, 'update'])->name('question-update');
        Route::post('delete/{question:uuid}', [QuestionController::class, 'destroy'])->name('question-destroy');
    });

    /**
     * Prefix: 'answer'
     */
    Route::prefix('answer')->group(function() {
        Route::get('create/{question:uuid}', [AnswerController::class, 'create'])->name('answer-create');
        Route::post('store/{question:uuid}', [AnswerController::class, 'store'])->name('answer-store');
    });

    /**
     * Prefix: 'broadcasting'
     */
    Route::prefix('broadcasting')->group(function() {

        /**
         * Prefix: 'broadcasting/question'
         */
        Route::prefix('question')->group(function() {
            Route::get('set-question-active/{question:uuid}', [QuestionController::class, 'setQuestionActive'])->name('set-question-active');
            Route::get('open-question-for-answers', [QuestionController::class, 'openQuestionForAnswers'])->name('open-question-for-answers');
        });

        /**
         * Prefix: 'broadcasting/quiz'
         */
        Route::prefix('quiz')->group(function() {
            Route::get('begin-broadcast/{quiz:uuid}', [QuizController::class, 'beginBroadcast'])->name('begin-broadcast');
            Route::get('end-broadcast/{quiz:uuid}', [QuizController::class, 'endBroadcast'])->name('end-broadcast');
        });

        /**
         * Prefix: 'broadcasting/answer'
         */
        Route::prefix('answer')->group(function() {
            Route::post('add', [AnswerController::class, 'addAnswer'])->name('add-answer');
            Route::get('show/{answer:uuid}', [AnswerController::class, 'showAnswer'])->name('show-answer');
            Route::get('remove/{answer:uuid}', [AnswerController::class, 'removeAnswer'])->name('remove-answer');
        });
    });

    /**
     * Prefix: 'display
     */
    Route::prefix('display')->group(function() {
        Route::get('quiz', [QuizController::class, 'displayQuiz'])->name('display-quiz');
        Route::get('question', [QuestionController::class, 'displayActiveQuestion'])->name('display-active-question');
        Route::get('all-answers-for-question/{question:uuid}', [AnswerController::class, 'indexForQuestion'])->name('get-all-answers-for-question');
        Route::get('answers', [AnswerController::class, 'displayShowedAnswers'])->name('display-showed-answers');
    });

    Route::post('submit-answer', [AnswerController::class, 'addAnswer'])->name('submit-answer');
});

require __DIR__.'/auth.php';
