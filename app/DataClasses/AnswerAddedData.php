<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\DataClassInterface;
use App\Models\Answer;
use App\Models\Question;

class AnswerAddedData implements DataClassInterface
{
    /**
     * @var string
     */
    public $text;

    /**
     * @var Question
     */
    public $question;

    /**
     * @param string $text
     * @return void
     */
    public function setAnswer(string $text)
    {
        $this->text = $text;
    }

    /**
     * @param Question $question
     * @return void
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
    }
}
