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
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Disagree',
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Neutral',
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Agree',
        ]);
        
        DB::table('risk_assess_answers')->insert([
            'choice' => 'Strongly Agree',
        ]);
    }
}
