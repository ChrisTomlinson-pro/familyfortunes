<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $table = 'question';

    protected $guarded = [];

    protected $hidden = [
        'id',
        'quiz_id',
        'created_at',
        'updated_at',
        'is_broadcasting'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * @param string $text
     * @return void
     * @throws \ErrorException
     */
    public function addAnswer(string $text): void
    {
        $model = Answer::query()->create([
            'uuid'         => Str::uuid()->toString(),
            'question_id'  => $this->id,
            'text'         => $text
        ]);

        if (!$model instanceof Answer) {
            throw new \ErrorException('model failed to create', 500);
        }
    }

    /**
     * Clears the cache of question answers array
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget($this->uuid . '_answers');
        if (Cache::get('activeQuestion') === $this->uuid) {
            Cache::forget('activeQuestion');
        }
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
