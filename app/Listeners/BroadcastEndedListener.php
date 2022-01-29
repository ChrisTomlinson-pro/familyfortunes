<?php

namespace App\Listeners;

use App\DataClasses\BroadcastEndedData;
use App\Events\BroadcastEvent;
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
     * @param  object  $event
     * @return void
     */
    public function handle(BroadcastEvent $event)
    {
        $dataClass = $event->dataClass;
        if ($dataClass instanceof BroadcastEndedData) {
            EndQuizBroadcast::dispatch($dataClass);
        }
    }
}
