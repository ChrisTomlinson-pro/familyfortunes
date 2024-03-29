<?php

namespace App\Helpers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
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
    }

    /**
     * @return null
     */
    public function getActiveQuiz()
    {
        $this->setQuizAndQuestions();
        return $this->quiz;
    }

    /**
     * Checks if question is open for receiving answers
     * @param string $uuid
     * @return void
     */
    public function checkIfQuestionIsOpenForAnswers(string $uuid): bool
    {
        $openQuestion = Cache::get('openQuestion');
        return $uuid === $openQuestion;
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
            if (empty($quizUuid)) {
                return;
            }
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

    /**
     * Set showed answers for active question
     * @return void
     */
    public function setShowedAnswers(): void
    {
        if (empty($this->activeQuestion)) {
            abort(422, 'Active question not set');
        }

        $this->showedAnswers = Cache::get($this->activeQuestion->uuid . '_answers');
//        $this->showedAnswers = $this->activeQuestion->answers()->where('is_showing', true)->get();
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
