<?php

namespace App\Events;

use App\DataClasses\AnswerAddedData;
use App\DataClasses\QuizBroadcastEndedDataInterface;
use App\DataClasses\QuizBroadcastStartedDataInterface;
use App\DataClasses\Interfaces\DataClassInterface;
use App\DataClasses\OpenQuestionForAnswersData;
use App\DataClasses\RemoveAnswerData;
use App\DataClasses\SetQuestionActiveData;
use App\DataClasses\ShowAnswerData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastToChannelsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const QUIZ_BROADCASTS = [
        QuizBroadcastEndedDataInterface::class,
        QuizBroadcastStartedDataInterface::class
    ];

    /**
     * @var DataClassInterface
     */
    public $dataClass;

    /**
     * @var bool
     */
    public $closeQuestionsForAnswers;

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
    public function __construct(
        DataClassInterface $dataClass = null,
        bool $closeQuestionForAnswers = false
    )
    {
        $this->dataClass = $dataClass;
        $this->closeQuestionForAnswers = $closeQuestionForAnswers;
        $this->broadcastChannels = [
            new PrivateChannel('auth-quiz'),
            new Channel('public-quiz')
        ];
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
    private function setBroadcastData(): void
    {

        switch (true) {

            //
            case $this->dataClass instanceof QuizBroadcastStartedDataInterface:
                $this->broadcastData = [
                    'event' => 'broadcastStarted'
                ];
                break;

            case $this->dataClass instanceof QuizBroadcastEndedDataInterface:
                $this->broadcastData = [
                    'event' => 'broadcastEnded'
                ];
                break;

            //
            case $this->dataClass instanceof OpenQuestionForAnswersData:
                if ($this->closeQuestionForAnswers) {
                    $this->broadcastData = [
                        'event' => 'questionOpened'
                    ];
                } else {
                    $this->broadcastData = [
                        'event' => 'questionClosed'
                    ];
                }
                break;

            //
            case $this->dataClass instanceof AnswerAddedData:
                $this->broadcastChannels = [ new PrivateChannel('auth-quiz') ];
                $this->broadcastData = [
                    'event' => 'answerAdded'
                ];
                break;

            case $this->dataClass instanceof RemoveAnswerData:
                /** @var RemoveAnswerData $dataClass */
                $dataClass = $this->dataClass;
                $this->broadcastChannels = [ new PrivateChannel('auth-quiz') ];
                $this->broadcastData = [
                    'event' => 'removeAnswer',
                    'answer_uuid' => $dataClass->answer->uuid
                ];
                break;

            case $this->dataClass instanceof SetQuestionActiveData:
                /** @var SetQuestionActiveData $dataClass */
                $dataClass = $this->dataClass;
                $this->broadcastData = [
                    'event'         => 'questionSetActive',
                    'question_uuid' => $dataClass->question->uuid
                ];
                break;

            case $this->dataClass instanceof ShowAnswerData:
                /** @var ShowAnswerData $dataClass */
                $dataClass = $this->dataClass;
                $this->broadcastData = [
                    'event' => 'showAnswer',
                    'answer_uuid'  => $dataClass->answer->uuid
                ];
                break;

            //
            default:
                throw new \ErrorException('Broadcast data not recognised', 500);

        }
    }
}
