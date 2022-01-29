<?php

namespace App\Events;

use App\DataClasses\Interfaces\DataClassInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DataClassInterface
     */
    public $dataClass;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DataClassInterface $dataClass)
    {
        $this->dataClass =$dataClass;
    }
}
