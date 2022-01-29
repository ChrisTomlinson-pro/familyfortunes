<?php

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    $quizzes = \App\Models\Quiz::all();
    return view('dashboard', ['quizzes' => $quizzes]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function() {

    Route::get('admin-home', [\App\Http\Controllers\QuizController::class, 'index'])->name('admin-home');

    /**
     * Prefix: 'quiz'
     */
    Route::prefix('quiz')->group(function() {
        Route::get('begin-broadcast/{quiz:uuid}', [\App\Http\Controllers\QuizController::class, 'beginBroadcast'])->name('begin-broadcast');
        Route::get('create', [\App\Http\Controllers\QuizController::class, 'create'])->name('quiz-create');
        Route::post('store', [\App\Http\Controllers\QuizController::class, 'store'])->name('quiz-store');
        Route::get('show/{quiz:uuid}', [\App\Http\Controllers\QuizController::class, 'show'])->name('quiz-show');
        Route::delete('delete/{quiz:uuid}', [\App\Http\Controllers\QuizController::class, 'destroy'])->name('quiz-delete');
    });

    /**
     * Prefix: 'question'
     */
    Route::prefix('question')->group(function() {
        Route::post('store/{quiz:uuid}', [\App\Http\Controllers\QuestionController::class, 'store'])->name('question-store');
        Route::post('update/{question:uuid}', [\App\Http\Controllers\QuestionController::class, 'update'])->name('question-update');
        Route::post('delete/{question:uuid}', [\App\Http\Controllers\QuestionController::class, 'destroy'])->name('question-destroy');
    });

    /**
     * Prefix: 'answer'
     */
    Route::prefix('answer')->group(function() {
        Route::get('create/{question:uuid}', [\App\Http\Controllers\AnswerController::class, 'create'])->name('answer-create');
        Route::post('store/{question:uuid}', [\App\Http\Controllers\AnswerController::class, 'store'])->name('answer-store');
    });
});

require __DIR__.'/auth.php';
