<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskAssessQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /**
         * Run the database seeds.
         *
         * @return void
         */
        DB::table('risk_assess_questions')->insert([
            'topic' => 'Risk Tolerance',
            'question' => 'I am patient with my investments and can accept periods of negative investment returns and portfolio losses',
        ]);

        DB::table('risk_assess_questions')->insert([
            'topic' => 'Expected Return',
            'question' => 'I consider myself an aggressive investor and seek above average investment returns',
        ]);
        
        DB::table('risk_assess_questions')->insert([
            'topic' => 'Liquidity',
            'question' => 'Not including the amount I plan to invest, I have adequate liquid assets (cash and cash equivalent) to support myself and dependents for 6 months or more.',
        ]);
        
        DB::table('risk_assess_questions')->insert([
            'topic' => 'Investment Experience',
            'question' => 'I have prior investment experience with stocks, bonds and international investments and I understand the concept of investment risk.',
        ]);

        DB::table('risk_assess_questions')->insert([
            'topic' => 'Holding Period',
            'question' => 'I am confident I will not need to withdraw money from my investments for at least 10 years',
        ]);

        DB::table('risk_assess_questions')->insert([
            'topic' => 'Income Source',
            'question' => 'I expect a regular and stable income stream over the long term and I expect to be less reliant on portfolio income to meet my expenses',
        ]);

        DB::table('risk_assess_questions')->insert([
            'topic' => 'Ease of Management',
            'question' => 'I want to play an active role in managing my investments',
        ]);

        DB::table('risk_assess_questions')->insert([
            'topic' => 'Dependents',
            'question' => 'There are more than two dependents who rely on my income and investment holdings for financial support',
        ]);

        DB::table('risk_assess_questions')->insert([
            'topic' => 'Investment Risk',
            'question' => 'I get concerned if my investments fall in value day-to-day or month-to-month',
        ]);

        DB::table('risk_assess_questions')->insert([
            'topic' => 'Debt/Credit',
            'question' => 'My outstanding debt is low and my credit history is excellent',
        ]);
    }
}
