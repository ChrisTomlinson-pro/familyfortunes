<?php

namespace App\Jobs\Quiz;

use App\DataClasses\QuizBroadcastEndedData;
use App\Events\BroadcastToChannelsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class EndQuizBroadcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var QuizBroadcastEndedData
     */
    private $dataClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(QuizBroadcastEndedData $dataClass)
    {
        $this->dataClass = $dataClass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cache::forget('activeQuiz');
        Cache::put('broadcasting', false);
        BroadcastToChannelsEvent::dispatch($this->dataClass);
    }
}
