<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskAssessAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Strongly Disagree',
            'value' => 1,
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Disagree',
            'value' => 2,
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Neutral',
            'value' => 3,
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Agree',
            'value' => 4,
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Strongly Agree',
            'value' => 5,
        ]);
    }
}
