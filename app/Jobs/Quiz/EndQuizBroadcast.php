<?php

namespace App\Jobs\Quiz;

use App\DataClasses\QuizBroadcastEndedDataInterface;
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
     * @var QuizBroadcastEndedDataInterface
     */
    private $dataClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(QuizBroadcastEndedDataInterface $dataClass)
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
