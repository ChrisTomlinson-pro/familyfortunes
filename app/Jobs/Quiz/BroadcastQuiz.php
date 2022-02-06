<?php

namespace App\Jobs\Quiz;

use App\DataClasses\QuizBroadcastStartedDataInterface;
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
     * @var QuizBroadcastStartedDataInterface
     */
    private $dataClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(QuizBroadcastStartedDataInterface $dataClass)
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
        Cache::add('broadcasting', true);
        Cache::add('activeQuiz', $this->dataClass->quiz->getAttributeValue('uuid'));
        BroadcastToChannelsEvent::dispatch($this->dataClass);
    }
}
