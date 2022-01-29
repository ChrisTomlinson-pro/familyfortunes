<?php

namespace App\Listeners;

use App\DataClasses\BroadcastStartedData;
use App\Events\BroadcastEvent;
use App\Jobs\Quiz\BroadcastQuiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class BroadcastStartedListener
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
        if ($dataClass instanceof BroadcastStartedData) {
            BroadcastQuiz::dispatch($dataClass);
        }
    }
}
