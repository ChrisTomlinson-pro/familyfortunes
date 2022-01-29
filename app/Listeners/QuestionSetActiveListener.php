<?php

namespace App\Listeners;

use App\DataClasses\SetQuestionActiveData;
use App\Events\BroadcastEvent;
use App\Jobs\Question\SetQuestionActive;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QuestionSetActiveListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(BroadcastEvent $event)
    {
        $dataClass = $event->dataClass;
        if ($dataClass instanceof SetQuestionActiveData) {
            SetQuestionActive::dispatch($dataClass);
        }
    }
}
