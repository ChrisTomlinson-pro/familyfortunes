<?php

namespace App\Events;

use App\DataClasses\AnswerAddedData;
use App\DataClasses\Interfaces\DataClassInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerEvent
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
        $this->dataClass = $dataClass;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if ($this->dataClass instanceof AnswerAddedData) {
            return new PrivateChannel('auth-answer');
        }

        return new Channel('public-answer');
    }
}
