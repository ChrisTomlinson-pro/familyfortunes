<?php

namespace App\Http\Livewire;

use App\Helpers\CacheHelper;
use Livewire\Component;

class QuizAdminView extends Component
{
    public $broadcastingQuiz;
    public $activeQuestion;
    public $nextQuestion;
    public $answers;
    public $shownAnswers;

    private $cacheHelper;

    protected $listeners = [
        'echo:auth-quiz,broadcastStarted' => 'checkIfQuizIsBroadcasting',
        //receive answer listener too
    ];

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->cacheHelper = new CacheHelper();
        $this->checkIfQuizIsBroadcasting();
    }

    public function render()
    {
        return view('livewire.quiz-admin-view');
    }

    /**
     * @return void
     */
    private function checkIfQuizIsBroadcasting(): void
    {
        $quiz = $this->cacheHelper->getActiveQuiz();

        if (empty($quiz))
        {
            $this->broadcastingQuiz = null;
            return;
        }

        $this->broadcastingQuiz = $quiz;
        $this->cacheHelper->setActiveAndNextQuestion();
        $this->activeQuestion = $this->cacheHelper->activeQuestion;
        $this->nextQuestion = $this->cacheHelper->nextQuestion;
        $this->receiveAnswer();
    }

    /**
     * @return void
     */
    private function receiveAnswer(): void
    {
        // if there is no active question set in active question then end process
        if (empty($this->cacheHelper->activeQuestion)) {
            return;
        }

        $this->cacheHelper->setAllAnswersForActiveQuestion();
        $this->answers = $this->cacheHelper->allAnswersForActiveQuestion;
        $this->setShownAnswers();
    }

    private function setShownAnswers()
    {
        $this->cacheHelper->setShowedAnswers();
        $this->shownAnswers = $this->cacheHelper->showedAnswers;
    }
}
