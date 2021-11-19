<?php

namespace App\Helpers;

// payment types
define('FINANCE_PAY_END', 0);
define('FINANCE_PAY_BEGIN', 1);

class FinanceUtils
{
    public static $savings_rate = 4.0;
    public static $retirement_age = 60;
    public static $life_expectancy = 85;
    public static $inflation = 6.0;
    public static $post_freedom_inflation = 6.0;
    public static $post_freedom_returns = 7.0;
    public static $post_freedom_tax_rate = 0;
    public static $epf_interest_rate = 6.0;
    public static $cash_flow_cagr = 12.0;

    public function __construct()
    {
    }

    public static function presentValue($interest_rate, $years, $future_value)
    {
        $pv = $future_value / pow(1 + ($interest_rate / 100), $years);

        return round($pv, 2);
    }
    
    /*
        PMT - periodic monthly payments
    */
    public static function presentValueAnnuity($PMT, $interest_rate, $number_of_periods)
    {
        $r = $interest_rate / 100;
        $d = 1 / pow(1 + $r, $number_of_periods);
        $p = $PMT * ((1 - $d) / $r);

        return round($p, 2);
    }

    public static function futureValue($interest_rate, $years, $present_value)
    {
        $fv = $present_value * pow(1 + ($interest_rate / 100), $years);
        
        return round($fv, 2);
    }
}
