<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\QuizDataClassInterface;
use App\Models\Quiz;

class QuizBroadcastStartedData implements QuizDataClassInterface
{
    /**
     * @var Quiz
     */
    public $quiz;

    public function setQuiz(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }
}
