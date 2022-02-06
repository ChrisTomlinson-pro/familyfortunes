<?php

namespace App\DataClasses;

use App\DataClasses\Interfaces\QuestionDataClassInterface;
use App\Models\Question;

class OpenQuestionForAnswersData implements QuestionDataClassInterface
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
