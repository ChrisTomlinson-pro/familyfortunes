<?php

namespace App\Http\Controllers;

use App\DataClasses\QuizBroadcastEndedData;
use App\DataClasses\QuizBroadcastStartedData;
use App\Events\QuizEvent;
use App\Helpers\CacheHelper;
use App\Http\Resources\DisplayQuizResource;
use App\Http\Resources\QuestionResource;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Psy\Exception\ErrorException;

class QuizController extends Controller
{
    /**
     * Get all questions to display on dashboard
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function getAllQuestions(Quiz $quiz): JsonResponse
    {
        $questions = $quiz->questions;
        return (new QuestionResource($questions))->response();
    }

    /**
     * Start the quiz broadcast
     * @param Quiz $quiz
     * @return void
     */
    public static function beginBroadcast(Quiz $quiz): void
    {
        $dataClass = new QuizBroadcastStartedData();
        $dataClass->setQuiz($quiz);
        QuizEvent::dispatch($dataClass);
    }

    /**
     * End the broadcast
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public static function endBroadCast(Quiz $quiz): JsonResponse
    {
        $dataClass = new QuizBroadcastEndedData();
        $dataClass->setQuiz($quiz);
        QuizEvent::dispatch($dataClass);
        return response()->json([], 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $quizzes = Quiz::all();

        return view('quiz/index', ['quizzes' => $quizzes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('quiz/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     * @throws \ErrorException
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => "required|string|max:100"
        ]);

        $quiz = Quiz::query()->create([
            'uuid' => Str::uuid()->toString(),
            'name' => $data['name']
        ]);

        if($quiz instanceof Quiz) {
            return redirect()->route('quiz-show', ['quiz' => $quiz->uuid]);
        }

        throw new \ErrorException('Failed to create quiz');
    }

    /**
     * Display the specified resource.
     *
     * @param Quiz $quiz
     * @return View
     */
    public function show(Quiz $quiz)
    {
        $questionsAndAnswers = $quiz->questions()->with('answers')->get();
        return view('quiz.show', [
            'quiz' => $quiz,
            'questionsAndAnswers' => $questionsAndAnswers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Quiz $quiz
     * @return View
     */
    public function edit(Quiz $quiz)
    {
        return view('quiz/edit', ['quiz' => $quiz]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Quiz $quiz
     * @return RedirectResponse
     * @throws ErrorException
     */
    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate(['name' => 'required|string']);

        if($quiz->update(['name' => $data['name']])) {
            return redirect()->route('admin_home');
        }

        throw new ErrorException('Failed to update quiz');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Quiz $quiz
     */
    public static function destroy(Quiz $quiz): void
    {
        $quiz->delete();
    }

    /**
     * Returns data to display the broadcasted quiz
     * @return JsonResponse
     */
    public function displayQuiz(): JsonResponse
    {
        $cacheHelper = new CacheHelper();
        $cacheHelper->setQuizAndQuestions();
        return (new DisplayQuizResource($cacheHelper->quiz))->response();
    }
}
