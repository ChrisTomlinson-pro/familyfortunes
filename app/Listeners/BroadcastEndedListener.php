<?php

namespace App\Listeners;

use App\DataClasses\QuizBroadcastEndedData;
use App\Events\QuizEvent;
use App\Jobs\Quiz\EndQuizBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BroadcastEndedListener
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
     * @param QuizEvent $event
     * @return void
     */
    public function handle(QuizEvent $event)
    {
        $dataClass = $event->dataClass;
        if ($dataClass instanceof QuizBroadcastEndedData) {
            EndQuizBroadcast::dispatchSync($dataClass);
        }
    }
}
