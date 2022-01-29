<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\DataClassInterface;
use App\Models\Answer;
use App\Models\Question;

class RemoveAnswerData implements DataClassInterface
{
    /**
     * @var Answer
     */
    public $answer;

    /**
     * @param Answer $answer
     * @return void
     */
    public function setAnswer(Answer $answer)
    {
        $this->answer = $answer;
    }
}
