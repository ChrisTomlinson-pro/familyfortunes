<?php

namespace App\Helpers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * @var Quiz
     */
    public $quiz;

    /**
     * @var Question
     */
    public $activeQuestion;

    /**
     * @var Question
     */
    public $nextQuestion;

    /**
     * @var Collection
     */
    public $questions;

    /**
     * @var array
     */
    public $showedAnswers;

    /**
     * @var Collection
     */
    public $allAnswersForActiveQuestion;

    public function __construct()
    {
        $this->checkIfBroadcasting();
    }

    /**
     * @return void
     */
    private function checkIfBroadcasting(): void
    {
        if (!Cache::get('broadcasting')) {
            abort(422, 'No quiz currently broadcasting');
        }
    }

    /**
     * @param Quiz|null $quiz
     * @return void
     */
    public function setQuizAndQuestions(Quiz $quiz = null): void
    {
        if (isset($quiz)) {
            $this->quiz = $quiz;
        } else {
            $quizUuid = Cache::get('activeQuiz');
            $quizQuery = Quiz::query();

            $quizQuery->where('uuid', $quizUuid);
            $quizQuery->with('questions');
            $this->quiz = $quizQuery->first();
        }

        $this->questions = $this->quiz->questions;
        $this->checkResults();
    }

    /**
     * @return void
     */
    public function setActiveAndNextQuestion(): void
    {
        if (empty($this->quiz)) {
            abort( 422, 'quiz not set');
        }

        $questionUuid = Cache::get($this->quiz->uuid . "_question");

        //find some way to display the answers, maybe without making a new endpoint
        if (isset($questionUuid)) {
            $this->activeQuestion = $this->questions->where('uuid', $questionUuid)->first();
            $index = collect($this->questions)->search($this->activeQuestion);
            $this->nextQuestion = Arr::get($this->questions, $index + 1);
            return;
        }

        $this->nextQuestion = $this->questions->first();
    }

    public function setAllAnswersForActiveQuestion()
    {
        if (empty($this->activeQuestion)) {
            abort( 422, 'active question not set');
        }

        $this->allAnswersForActiveQuestion = $this->activeQuestion->answers;
    }

    public function setShowedAnswers()
    {
        if (empty($this->activeQuestion)) {
            abort(422, 'Active question not set');
        }

        $this->showedAnswers = Cache::get($this->activeQuestion->uuid . '_answers');

        if (empty($this->showedAnswers)) {
            abort(422, 'Answers have not been set');
        }
    }

    public function checkResults()
    {
        if (empty($this->quiz)) {
            abort(422, 'Broadcasting quiz not set');
        }

        if (empty($this->questions)) {
            abort(422, 'Questions for quiz not set');
        }
    }
}
