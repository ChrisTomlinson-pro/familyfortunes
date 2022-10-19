<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $guarded = [];

    protected $casts = [
        'is_broadcasting' => 'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function addQuestion(string $text): Question
    {
        return Question::create([
            'uuid'      => Str::uuid()->toString(),
            'text'      => $text,
            'quiz_id'   => $this->id
        ]);
    }

    /**
     * Remove the cache entry that saves the active question for this quiz
     * @return void
     */
    public function cleanCache(): void
    {
        $cacheKey = $this->uuid . '_question';
        if (!empty(Cache::get($cacheKey))) {
            Cache::forget($cacheKey);
        }
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }
}
