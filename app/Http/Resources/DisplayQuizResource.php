<?php

namespace App\Http\Resources;

use App\Helpers\CacheHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class DisplayQuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \ErrorException
     */
    public function toArray($request): array
    {
        $cacheHelper = new CacheHelper();
        $cacheHelper->setQuizAndQuestions($this->resource);
        $cacheHelper->setActiveAndNextQuestion();
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'activeQuestion' => $cacheHelper->activeQuestion,
            'nextQuestion' => $cacheHelper->nextQuestion,
            'questions' => $this->questions
        ];
    }
}
