<?php

namespace App\Events;

use App\DataClasses\AnswerAddedData;
use App\DataClasses\BroadcastEndedData;
use App\DataClasses\BroadcastStartedData;
use App\DataClasses\Interfaces\DataClassInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransmitToChannelsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const QUIZ_BROADCASTS = [
        BroadcastEndedData::class,
        BroadcastStartedData::class
    ];

    /**
     * @var DataClassInterface
     */
    public $dataClass;

    /**
     * @var bool
     */
    public $broadcastEnd;

    /**
     * @var array
     */
    public $broadcastData;

    /**
     * @var array
     */
    public $broadcastChannels;

    /**
     * Create a new event instance.
     *
     * @return void
     * @throws \ErrorException
     */
    public function __construct(DataClassInterface $dataClass = null, bool $broadcastEnd = false)
    {
        $this->dataClass = $dataClass;
        $this->broadcastEnd = $broadcastEnd;
        $this->setBroadcastData();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return $this->broadcastChannels;
    }

    public function broadcastWith()
    {
        return $this->broadcastData;
    }

    /**
     * @return void
     * @throws \ErrorException
     */
    private function setBroadcastData()
    {
        switch (true) {
            case in_array($this->dataClass, self::QUIZ_BROADCASTS):
                $this->broadcastChannels = [
                    new PrivateChannel('auth-quiz'),
                    new Channel('public-quiz')
                ];
                $this->broadcastData = [];
                break;

            default:
                throw new \ErrorException('Broadcast data not recognised', 500);

        }
    }
}
