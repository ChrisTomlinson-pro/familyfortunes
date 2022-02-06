<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\QuizDataClassInterface;
use App\Models\Quiz;

class QuizBroadcastStartedDataInterface implements QuizDataClassInterface
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
