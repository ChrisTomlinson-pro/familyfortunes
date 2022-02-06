<?php

namespace App\Jobs\Question;

use App\DataClasses\OpenQuestionForAnswersData;
use App\Events\BroadcastToChannelsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class OpenQuestionForAnswers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const SLEEP_TIME = 20;

    /**
     * @var OpenQuestionForAnswersData
     */
    private $dataClass;

    public $timeout = 30;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OpenQuestionForAnswersData $dataClass)
    {
        $this->queue = 'default';
        $this->dataClass = $dataClass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cache::put('openQuestion', $this->dataClass->question->uuid, self::SLEEP_TIME);
        BroadcastToChannelsEvent::dispatch($this->dataClass);
        sleep(self::SLEEP_TIME);
        BroadcastToChannelsEvent::dispatch($this->dataClass, true);
    }
}
