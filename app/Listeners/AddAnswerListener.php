<?php

namespace App\Listeners;

use App\DataClasses\AnswerAddedData;
use App\Events\AnswerEvent;
use App\Jobs\Answer\AddAnswer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddAnswerListener
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

        if ($dataClass instanceof AnswerAddedData) {
            AddAnswer::dispatch($dataClass);
        }
    }
}
