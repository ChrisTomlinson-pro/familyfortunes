<?php

namespace App\Jobs\Quiz;

use App\DataClasses\QuizBroadcastStartedData;
use App\Events\BroadcastToChannelsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class BroadcastQuiz implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var QuizBroadcastStartedData
     */
    private $dataClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(QuizBroadcastStartedData $dataClass)
    {
        $this->dataClass = $dataClass;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \ErrorException
     */
    public function handle()
    {
        Cache::put('broadcasting', true);
        Cache::put('activeQuiz', $this->dataClass->quiz->getAttributeValue('uuid'));
        event(new BroadcastToChannelsEvent($this->dataClass));
    }
}
