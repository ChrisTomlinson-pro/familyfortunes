<?php

namespace App\Listeners;

use App\DataClasses\OpenQuestionForAnswersData;
use App\Events\QuestionEvent;
use App\Jobs\Question\OpenQuestionForAnswers;
use App\Jobs\Question\SetQuestionActive;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OpenQuestionForAnswersListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param QuestionEvent $event
     * @return void
     */
    public function handle(QuestionEvent $event)
    {
        $dataClass = $event->dataClass;
        if ($dataClass instanceof OpenQuestionForAnswersData) {
            OpenQuestionForAnswers::dispatch($dataClass);
        }
    }
}
