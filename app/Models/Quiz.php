<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function questions() {
        return $this->hasMany(Question::class);
    }
}
