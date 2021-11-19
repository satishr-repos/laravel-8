<?php

namespace App\Helpers;

use App\Models\Customer;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class IncomeExpenseHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
   
    public function getIncomes()
    {
        $total = 0;

        $data = array();

        $salary = $this->customer->salaryIncomes;
        $annual = round($salary->sum('net_salry'), 2);
        $monthly = round($annual / 12, 2);
        $data['Salary'] =  array('Type' => 'Salary', 'Annual' => $annual, 'Monthly' => $monthly);
        $total += $annual;

        $rental = $this->customer->rentalIncomes;
        $annual = round($rental->sum('annul_inc'), 2);
        $monthly = round($annual / 12, 2);
        $data['Rental'] =  array('Type' => 'Rental','Annual' => $annual, 'Monthly' => $monthly);
        $total += $annual;

        $pension = $this->customer->pensionIncomes;
        $annual = round($pension->sum('annul_inc'), 2);
        $monthly = round($annual / 12, 2);
        $data['Pension'] =  array('Type' => 'Pension','Annual' => $annual, 'Monthly' => $monthly);
        $total += $annual;

        $other = $this->customer->otherIncomes;
        $annual = round($other->sum('annul_inc'), 2);
        $monthly = round($annual / 12, 2);
        $data['Other'] =  array('Type' => 'Other','Annual' => $annual, 'Monthly' => $monthly);
        $total += $annual;

        $data['Total'] = array('Type' => 'Total','Annual' => $total, 'Monthly' => round($total / 12, 2));

        return $data;
    }

    public function getExpenses()
    {
        $expenses = $this->customer->expenses->groupBy('exp_typ');

        $data = array();

        $total = 0;
        $essential = 0;

        foreach($expenses as $mainKey=>$expense)
        {
            $grouped = $expense->groupBy('exp_typ_sub');
            $data[$mainKey] = array();
            foreach($grouped as $subKey=>$group)
            {
                $annual = round($group->sum('annul_exp'), 2);
                $monthly = round($annual / 12, 2);
                array_push($data[$mainKey], array('Type' => $subKey, 'Annual' => $annual, 'Monthly' => $monthly));

                for ($x = 0; $x < count($group); $x++) {
                    if (($group[$x]['is_essential']) == 1) {
                        $essential += $group[$x]['annul_exp'];
                    }
                }
                $total += $annual;
            }
        }

        $data['Essential'] = array('Type' => 'Essential','Annual' => round($essential,2), 'Monthly' => round($essential/12, 2));
        $data['Proposed Investment'] = array('Type' => 'Proposed Investment','Annual' => 0, 'Monthly' => 0);
        $data['Surplus'] = array('Type' => 'Surplus','Annual' => 0, 'Monthly' => 0);
        $data['Total'] = array('Type' => 'Total','Annual' => round($total, 2), 'Monthly' => round($total / 12, 2));

        return $data;
    }

    public function report()
    {
        $outflow = $this->getExpenses();
        $inflow = $this->getIncomes();

        $proposed = 0;
        $surplus = $inflow['Total']['Annual'] - $outflow['Total']['Annual'];
        if($surplus > 0)
        {
            $proposed = $surplus * 0.9;
            $surplus -= $proposed;
        }

        $proposed = round($proposed, 2);
        $surplus = round($surplus, 2);

        $outflow['Proposed Investment'] = array('Type' => 'Proposed Investment', 'Annual' => $proposed, 'Monthly' => round($proposed / 12, 2));
        $outflow['Surplus'] = array('Type' => 'Surplus','Annual' => $surplus, 'Monthly' => round($surplus / 12, 2));

        $total = $proposed + $surplus + $outflow['Total']['Annual'];
        $outflow['Total']['Annual'] = round($total, 2);
        $outflow['Total']['Monthly'] = round($total / 12, 2);
   
        return compact('outflow', 'inflow');
    }

}
