<?php

namespace App\Helpers;

use App\Models\Customer;
use DateTime;

class GoalsHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function childGoals()
    {
        $total = 0;
        $goals = $this->customer->goals;
        foreach($goals as $goal)
        {
            if( ($goal->goal_typ == 'Children Education') ||
                ($goal->goal_typ == 'Children Marriage') )
            {
                $total += $goal->current_cost;
            }
        }

        return round($total, 2);
    }

    public function report()
    {
        $i = 0;
        $data = array();

        $current_total = 0;
        $future_total = 0;
        $cash_flow_total = 0;
            
        $debt_maturity_value = 0;

        $goals = $this->customer->goals;
        foreach($goals as $goal)
        {
            $principal = $goal->current_cost;
            $interest_rate = $goal->inflation;
            $target_date = new DateTime($goal->goal_target_dt);
            $start_date = new DateTime($goal->goal_start_dt);
            $interval = $target_date->diff($start_date);

            // echo "$goal->goal_typ " . PHP_EOL;
            // echo "Years: $interval->y Months: $interval->m" . PHP_EOL;

            $future_value = FinanceUtils::futureValue($interest_rate, $interval->y, $principal);

            $cash_flow_from_equity = $future_value - $debt_maturity_value;

            $data[$i] = array($goal->goal_typ, $goal->goal_desc, $target_date->format('Y'), 
                            $principal, $future_value, $interest_rate, $debt_maturity_value, $cash_flow_from_equity);

            $current_total += $principal;
            $future_total += $future_value;
            $cash_flow_total += $cash_flow_from_equity;

            $i++;
        }

        $data[$i] = array("", 'Total', "", round($current_total,2), round($future_total,2),'', $debt_maturity_value, round($cash_flow_total,2));

        return $data;
    }

}
