<?php

namespace App\Http\Controllers;

use App\DataClasses\AnswerAddedData;
use App\DataClasses\RemoveAnswerData;
use App\DataClasses\ShowAnswerData;
use App\Events\AnswerEvent;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnswerController extends Controller
{

    /**
     * Add an answer
     * @param Request $request
     * @return JsonResponse
     */
    public function addAnswer(Request $request): JsonResponse
    {
        $data = $request->validate([
            'text'      => 'required|string|max:255',
            'question'  => 'required|string|max:255'
        ]);

        $dataClass = new AnswerAddedData();
        $dataClass->setAnswerText($data['text']);
        $dataClass->setQuestion($data['question']);
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

        return response()->json([], 201);
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
     * @return View
     */
    public function create(Question $question)
    {
        return view('answer/create', ['question' => $question]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ErrorException
     */
    public function store(Request $request, Question $question)
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
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
