<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\AnswerDataClassInterface;
use App\Models\Answer;

class ShowAnswerData implements AnswerDataClassInterface
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
