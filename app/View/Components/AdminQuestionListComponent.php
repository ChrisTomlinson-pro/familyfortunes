<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminQuestionListComponent extends Component
{
    public $questions;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-question-list-component');
    }
}
