<?php

namespace App\Observers;

use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the Question "created" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function created(Question $question)
    {
        //
    }

    /**
     * Handle the Question "updated" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function updated(Question $question)
    {
        //
    }

    /**
     * Handle the Question "deleted" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function delete(Question $question)
    {
        $question->clearCache();
    }

    /**
     * Handle the Question "restored" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function restored(Question $question)
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     *
     * @param  \App\Models\Question  $question
     * @return void
     */
    public function forceDeleted(Question $question)
    {
        //
    }
}
