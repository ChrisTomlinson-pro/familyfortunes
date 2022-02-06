<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\AnswerDataClassInterface;
use App\Models\Question;

class AnswerAddedData implements AnswerDataClassInterface
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
    public function setAnswerText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @param string $question_uuid
     * @return void
     */
    public function setQuestion(string $question_uuid)
    {
        $question = Question::where('uuid', $question_uuid)->first();
        $this->question = $question;
    }
}
