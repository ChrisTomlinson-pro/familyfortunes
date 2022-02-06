<?php

namespace App\Http\Controllers;

use App\DataClasses\AnswerAddedData;
use App\DataClasses\RemoveAnswerData;
use App\DataClasses\ShowAnswerData;
use App\Events\AnswerEvent;
use App\Helpers\CacheHelper;
use App\Http\Resources\AnswersResource;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AnswerController extends Controller
{

    /**
     * Add an answer
     * @param Request $request
     * @return JsonResponse
     */
    public function addAnswer(Request $request)
    {
        $data = $request->validate([
            'text'      => 'required|string|max:255',
            'question_uuid'  => 'required|string|max:255'
        ]);

        $cacheHelper = new CacheHelper();
        $isOpen = $cacheHelper->checkIfQuestionIsOpenForAnswers($request->question_uuid);

        if (!$isOpen) {
            abort(401, "Question no longer open for answers");
        }

        $dataClass = new AnswerAddedData();
        $dataClass->setAnswerText($data['text']);
        $dataClass->setQuestion($data['question_uuid']);
        AnswerEvent::dispatch($dataClass);

        return response()->json([], 201);
    }

    /**
     * @param Answer $answer
     * @return JsonResponse
     */
    public function showAnswer(Answer $answer): JsonResponse
    {
        $dataClass = new ShowAnswerData();
        $dataClass->setAnswer($answer);
        AnswerEvent::dispatch($dataClass);

        return response()->json([], 200);
    }

    /**
     * @param Answer $answer
     * @return JsonResponse
     */
    public function removeAnswer(Answer $answer): JsonResponse
    {
        $dataClass = new RemoveAnswerData();
        $dataClass->setAnswer($answer);
        AnswerEvent::dispatch($dataClass);
        return response()->json([], 201);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Question $question
     * @return View
     */
    public function create(Question $question): View
    {
        return view('answer/create', ['question' => $question]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @return RedirectResponse
     * @throws \ErrorException
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        $data = $request->validate([
            'text' => 'required|string'
        ]);
        $data['question_id'] = $question->id;

        $answer = Answer::query()->create($data);

        if ($answer instanceof Answer) {
            return redirect()->route('pending_next_question');
        }

        throw new \ErrorException('failed to create answer');
    }

    /**
     * @param Question $question
     * @return mixed
     */
    public function indexForQuestion(Question $question): JsonResponse
    {
        return response()->json([
            'answers' => $question->answers
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Answer $answer
     * @return Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Answer $answer
     * @return Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function displayShowedAnswers()
    {
        $cacheHelper = new CacheHelper();
        $cacheHelper->setQuizAndQuestions();
        $cacheHelper->setActiveAndNextQuestion();
        $cacheHelper->setShowedAnswers();

        return (new AnswersResource($cacheHelper->showedAnswers))->response();
    }
}
