<?php

namespace App\Listeners;

use App\DataClasses\RemoveAnswerData;
use App\Events\AnswerEvent;
use App\Jobs\Answer\RemoveAnswer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveAnswerListener
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
     * @param AnswerEvent $event
     * @return void
     */
    public function handle(AnswerEvent $event)
    {
        $dataClass = $event->dataClass;
        if ($dataClass instanceof RemoveAnswerData) {
            RemoveAnswer::dispatch($dataClass);
        }
    }
}
