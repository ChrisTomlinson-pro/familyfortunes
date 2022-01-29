<?php

namespace App\Http\Controllers;

use App\DataClasses\BroadcastEndedData;
use App\DataClasses\BroadcastStartedData;
use App\Events\BroadcastEvent;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Psy\Exception\ErrorException;

class QuizController extends Controller
{
    /**
     * Start the quiz broadcast
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function beginBroadcast(Quiz $quiz): JsonResponse
    {
        $dataClass = new BroadcastStartedData();
        $dataClass->setQuiz($quiz);
        BroadcastEvent::dispatch($dataClass);
        //dispatch broadcast event
        //set in cache broadcast is active
        return response()->json([], 201);
    }

    /**
     * End the broadcast
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function endBroadCast(Quiz $quiz): JsonResponse
    {
        $dataClass = new BroadcastEndedData();
        $dataClass->setQuiz($quiz);
        BroadcastEvent::dispatch($dataClass);
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
     * @return \Illuminate\Http\RedirectResponse
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
     * @param  \App\Models\Quiz  $quiz
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
     * @param  \App\Models\Quiz  $quiz
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
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
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
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ErrorException
     */
    public function destroy(Quiz $quiz)
    {
        if($quiz->delete()) {
            return redirect()->route('admin_home');
        }

        throw new \ErrorException('Failed to delete quiz');
    }
}
