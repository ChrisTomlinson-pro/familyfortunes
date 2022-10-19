<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quizNames = [
            'quiz1',
            'quiz2',
            'quiz3'
        ];

        $questionTexts = [
            'question1',
            'question2',
            'question3',
            'question4'
        ];

        foreach ($quizNames as $name) {
            /** @var Quiz $quiz */
            $quiz = Quiz::create([
                'uuid' => Str::uuid()->toString(),
                'name' => $name
            ]);

            foreach ($questionTexts as $text) {
                $quiz->addQuestion($text);
            }
        }
    }
}
