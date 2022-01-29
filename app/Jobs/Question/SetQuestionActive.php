<?php

namespace App\Jobs\Question;

use App\DataClasses\SetQuestionActiveData;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SetQuestionActive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Question
     */
    private $question;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SetQuestionActiveData $dataClass)
    {
        $this->question = $dataClass->question;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cacheKey = $this->question->quiz->uuid . '_question';
        Cache::put($cacheKey, $this->question->uuid);
    }
}
