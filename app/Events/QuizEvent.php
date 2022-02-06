<?php

namespace App\Events;

use App\DataClasses\Interfaces\QuizDataClassInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var QuizDataClassInterface
     */
    public $dataClass;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(QuizDataClassInterface $dataClass)
    {
        $this->dataClass =$dataClass;
    }
}
