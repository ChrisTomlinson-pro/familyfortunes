<?php

namespace App\Providers;

use App\Events\AnswerEvent;
use App\Events\QuestionEvent;
use App\Events\QuizEvent;
use App\Listeners\AddAnswerListener;
use App\Listeners\BroadcastEndedListener;
use App\Listeners\BroadcastStartedListener;
use App\Listeners\OpenQuestionForAnswersListener;
use App\Listeners\QuestionSetActiveListener;
use App\Listeners\RemoveAnswerListener;
use App\Listeners\ShowAnswerListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        QuizEvent::class => [
            BroadcastStartedListener::class,
            BroadcastEndedListener::class
        ],

        QuestionEvent::class => [
            QuestionSetActiveListener::class,
            OpenQuestionForAnswersListener::class
        ],

        AnswerEvent::class => [
            AddAnswerListener::class,
            RemoveAnswerListener::class,
            ShowAnswerListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
