<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'question';

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * @param string $text
     * @return void
     * @throws \ErrorException
     */
    public function addAnswer(string $text)
    {
        $model = Answer::query()->create([
            'question_id'  => $this->id,
            'text'         => $text
        ]);

        if (!$model instanceof Answer) {
            throw new \ErrorException('model failed to create', 500);
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
