<?php

namespace App\Helpers;

use App\Models\Customer;
use Carbon\Carbon;
use DateTime;

class EpfHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getEpfData()
    {
        $data = array();
        $now = new DateTime(Carbon::now());

        $salaries = $this->customer->salaryIncomes;
        foreach($salaries as $salary)
        {
            $epfAsset = $salary->retirementAsset;
            if($epfAsset)
            {
                $item = array();
            
                $dob = new DateTime($this->customer->personalDetail->dob);
                $age = $now->diff($dob)->y;
                $item['Current Age'] = $age;
            
                $item['Retirement Age'] = FinanceUtils::$retirement_age;
                $item['Monthly Basic'] = $salary->basic_salry;
                $item['Growth'] = $salary->grwth_rt;

                $item['Employee Contribution'] = $epfAsset->employe_contrb;
                $item['Employer Contribution'] = $epfAsset->employr_contrb;
                $item['EPF Balance'] = $epfAsset->accmultd_value;
                $item['Interest Rate'] = FinanceUtils::$epf_interest_rate;
            
                array_push($data, $item);
            }
        }

        return $data;
    }

    public function report()
    {
        $data = array();

        $records = $this->getEpfData();
        foreach($records as $key=>$record)
        {
            $start = $record['Current Age'];
            $end = $record['Retirement Age'];

            $growth_rate = 1 + $record['Growth'] / 100;
            $annual_salary = $record['Monthly Basic'] * 12;
            $employee_contrib = 1 + $record['Employee Contribution'] / 100;
            $employer_contrib = 1 + $record['Employer Contribution'] / 100;
            $epf_balance = $record['EPF Balance'];
            $epf_interest = 1 + $record['Interest Rate'] / 100;

            $record['Value at Retirement'] = 0;
            $data[$key] = $record;

            $final_balance = 0;
            for($i=1; $i <= ($end - $start); $i++)
            {
                $item = array();
                $item['Age'] = $start + $i;
                $item['Annual Salary'] = round($annual_salary * $growth_rate, 2);
            
                $annual_salary = $item['Annual Salary'];
                $own_contribution = $annual_salary * $employee_contrib;
                $company_contribution = $annual_salary * $employer_contrib;
                $item['Own Contribution'] = round($own_contribution, 2);
                $item['Company Contribution'] = round($company_contribution, 2);

                $total_balance = $epf_balance + $own_contribution + $company_contribution;
                $item['Total Balance'] = round($total_balance, 2);

                $final_balance = $total_balance * $epf_interest;                
                $item['Balance+Interest'] = round($final_balance,2);

                $epf_balance = $total_balance;

                array_push($data[$key], $item);
            }
                
            $data[$key]['Value at Retirement'] = $final_balance;

        }

        return $data;
    }

}