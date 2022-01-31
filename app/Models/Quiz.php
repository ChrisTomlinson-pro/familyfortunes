<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    /**
     * Remove the cache entry that saves the active question for this quiz
     * @return void
     */
    public function cleanCache(): void
    {
        Cache::forget($this->uuid . '_question');
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }
}
