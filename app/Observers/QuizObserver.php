<?php

namespace App\Observers;

use App\Models\Quiz;

class QuizObserver
{
    /**
     * Handle the Quiz "created" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function created(Quiz $quiz)
    {
        //
    }

    /**
     * Handle the Quiz "updated" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function updated(Quiz $quiz)
    {
        //
    }

    /**
     * Handle the Quiz "delete" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function delete(Quiz $quiz)
    {
        //get all the answers and questions from the cache and remove
        $quiz->cleanCache();
    }

    /**
     * Handle the Quiz "restored" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function restored(Quiz $quiz)
    {
        //
    }

    /**
     * Handle the Quiz "force deleted" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function forceDeleted(Quiz $quiz)
    {
        //
    }
}
