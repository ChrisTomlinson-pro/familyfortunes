<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
