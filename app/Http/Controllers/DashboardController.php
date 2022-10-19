<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function show()
    {
        $quizzes = \App\Models\Quiz::all();
        $isBroadcasting = Cache::get('broadcasting');
        $activeQuiz = Cache::get('activeQuiz');
        return view('dashboard', [
            'quizzes'           => $quizzes,
            'isBroadcasting'    => $isBroadcasting,
            'activeQuiz'        => $activeQuiz
        ]);
    }
}
