<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\DataClassInterface;
use App\Models\Question;

class OpenQuestionForAnswersData implements DataClassInterface
{
    /**
     * @var Question
     */
    public $question;

    public function setQuestion(Question $question)
    {
        $this->question = $question;
    }
}
