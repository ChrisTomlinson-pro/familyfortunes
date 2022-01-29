<?php

namespace App\Listeners;

use App\DataClasses\ShowAnswerData;
use App\Events\AnswerEvent;
use App\Jobs\Answer\ShowAnswer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShowAnswerListener
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
        $dataclass = $event->dataClass;
        if ($dataclass instanceof ShowAnswerData) {
            ShowAnswer::dispatch($dataclass);
        }
    }
}
