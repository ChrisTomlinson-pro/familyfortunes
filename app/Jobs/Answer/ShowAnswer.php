<?php

namespace App\Jobs\Answer;

use App\DataClasses\ShowAnswerData;
use App\Events\BroadcastToChannelsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ShowAnswer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ShowAnswerData
     */
    private $dataClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ShowAnswerData $dataClass)
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
        $question = $this->dataClass->answer->question;
        $cacheKey = $question->uuid . '_answers';

        $cachedAnswers = Cache::get($cacheKey, []);
        if (!$cachedAnswers || !is_array($cachedAnswers)) {
            $cachedAnswers = [];
        }


        $newCacheData = [
            'uuid' => $this->dataClass->answer->uuid,
            'text' => $this->dataClass->answer->text
        ];

        $cachedAnswers[] = $newCacheData;
        Cache::put($cacheKey, $cachedAnswers);
        BroadcastToChannelsEvent::dispatch($this->dataClass);
    }
}
