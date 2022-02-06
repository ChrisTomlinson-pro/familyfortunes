<?php

namespace App\Events;

use App\DataClasses\Interfaces\QuestionDataClassInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var QuestionDataClassInterface
     */
    public $dataClass;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(QuestionDataClassInterface $dataClass)
    {
        $this->dataClass = $dataClass;
    }
}
