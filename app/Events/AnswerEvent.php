<?php

namespace App\Events;

use App\DataClasses\Interfaces\AnswerDataClassInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var AnswerDataClassInterface
     */
    public $dataClass;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AnswerDataClassInterface $dataClass)
    {
        $this->dataClass = $dataClass;
    }
}
