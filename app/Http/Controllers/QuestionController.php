<?php

namespace App\Http\Controllers;

use App\DataClasses\OpenQuestionForAnswersData;
use App\DataClasses\SetQuestionActiveData;
use App\Events\QuestionEvent;
use App\Helpers\CacheHelper;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Set question as active
     * @param Question $question
     * @return JsonResponse
     */
    public function setQuestionActive(Question $question): JsonResponse
    {
        $dataclass = new SetQuestionActiveData();
        $dataclass->setQuestion($question);
        QuestionEvent::dispatch($dataclass);

        return response()->json([], 201);
    }

    /**
     * @return JsonResponse
     */
    public function openQuestionForAnswers(): JsonResponse
    {
        $cacheHelper = new CacheHelper();
        $cacheHelper->setQuizAndQuestions();
        $cacheHelper->setActiveAndNextQuestion();
        $question = $cacheHelper->activeQuestion;

        $dataClass = new OpenQuestionForAnswersData();
        $dataClass->setQuestion($question);
        QuestionEvent::dispatch($dataClass);

        return response()->json([], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ErrorException
     */
    public function store(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'text' => 'required|string'
        ]);

        $question = Question::query()->create([
            'uuid'      => Str::uuid()->toString(),
            'text'      => $data['text'],
            'quiz_id'   => $quiz->id
        ]);

        if ($question instanceof Question) {
            return redirect()->route('quiz-show', ['quiz' => $quiz->uuid]);
        }

        throw new \ErrorException('failed to create quiz');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Question $question
     * @param Quiz $quiz
     * @return RedirectResponse
     * @throws \ErrorException
     */
    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'text' => 'required|string'
        ]);
        $quiz = $question->quiz;

        if ($question->update($data)) {
            return redirect()->route('quiz-show', ['quiz' => $quiz->uuid]);
        }

        throw new \ErrorException('failed to update question');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Question $question
     * @return RedirectResponse
     * @throws \ErrorException
     */
    public function destroy(Question $question)
    {
        $quiz = $question->quiz;
        if ($question->delete()) {
            return redirect()->route('quiz-show', ['quiz' => $quiz->uuid]);
        }

        throw new \ErrorException('failed to delete question');
    }

    /**
     * @return JsonResponse
     */
    public function displayActiveQuestion(): JsonResponse
    {
        $cacheHelper = new CacheHelper();
        $cacheHelper->setQuizAndQuestions();
        $cacheHelper->setActiveAndNextQuestion();
        if (empty($cacheHelper->activeQuestion)) {
            abort(422, 'Active question not set');
        }
        return (new QuestionResource($cacheHelper->activeQuestion))->response();
    }
}
