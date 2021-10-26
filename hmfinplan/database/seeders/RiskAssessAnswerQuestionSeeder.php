<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskAssessAnswerQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = DB::table('risk_assess_questions')->select('id')->get();
        $answers = DB::table('risk_assess_answers')->select('id')->get();

        // echo $questions;
        // echo $answers;
        foreach($questions as $question){
            foreach($answers as $answer){
                DB::table('risk_assess_answer_question')->insert([
                    'risk_assess_question_id' => $question->id,
                    'risk_assess_answer_id' => $answer->id,
                ]);
            }
        }
    }
}
