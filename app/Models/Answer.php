<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';

    protected $guarded = [];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'question_id'
    ];

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Clears question from questions array in cache
     * @return void
     */
    public function clearCache(): void
    {
        $questionUuid = $this->question->uuid;
        $cacheKey = $questionUuid . '_answers';
        $cachedAnswers = Cache::get($cacheKey);

        $newCachedAnswers = collect([]);
        foreach ($cachedAnswers as $answer) {
            if (!in_array($this->uuid, $answer)) {
                $newCachedAnswers->add($answer);
            }
        }

        Cache::put($cacheKey, $newCachedAnswers->toArray());
    }

    /**
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
