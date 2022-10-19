<?php

namespace App\Http\Livewire;

use App\Helpers\CacheHelper;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Models\Question;
use App\Models\Quiz;
use Livewire\Component;

class QuestionList extends Component
{
    public $activeQuiz;
    public $broadcastingQuiz;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->checkIfQuizIsBroadcasting();
    }

    public function deleteQuestion(Question $question)
    {
        QuestionController::destroy($question);
    }

    public function startBroadcast(Quiz $quiz)
    {
        QuizController::beginBroadcast($quiz);
        $this->broadcastingQuiz = $quiz;
    }

    public function endBroadcast(Quiz $quiz)
    {
        QuizController::endBroadCast($quiz);
        $this->broadcastingQuiz = null;
    }

    public function deleteQuiz(Quiz $quiz)
    {
        QuizController::destroy($quiz);
        $this->activeQuiz = null;
    }

    public function render()
    {
        $data['questions'] = [];
        $quizzes = Quiz::all()->sortByDesc('created_at');
        $data['quizzes'] = $quizzes;
        if (!empty($this->activeQuiz)) {
            $quiz = Quiz::query()->where('uuid', $this->activeQuiz)->with('questions')->firstOrFail();
            $data['questions'] = $quiz->questions;
        }

        return view('livewire.question-list', $data);
    }

    /**
     * @return void
     */
    private function checkIfQuizIsBroadcasting(): void
    {
        $cacheHelper = new CacheHelper();
        $quiz = $cacheHelper->getActiveQuiz();
        if (!empty($quiz)) {
            $this->broadcastingQuiz = $quiz;
        }
    }
}
