<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\DataClassInterface;
use App\Models\Quiz;

class BroadcastStartedData implements DataClassInterface
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
