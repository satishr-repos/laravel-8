<?php

namespace Database\Factories;

use App\Models\RiskTolerance;
use App\Models\RiskAssessQuestion;
use App\Models\RiskAssessAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiskToleranceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RiskTolerance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $count = 0;
        $ids = RiskAssessQuestion::pluck('id');
        $question = RiskAssessQuestion::find($ids[$count++]);
        if($count == $ids->count())
            $count = 0;
        $ansIds = $question->answers()->pluck('risk_assess_answers.id');
        $answer = RiskAssessAnswer::find($ansIds[array_rand($ansIds->toArray())]);// array_rand returns the key not value

        return [
            'question_id' => $question->id,
            'answer_id' => $answer->id,
        ];
    }
}
