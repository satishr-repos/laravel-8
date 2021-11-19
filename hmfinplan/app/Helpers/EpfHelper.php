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
                $item['Current Age'] = $age . 'yr';
            
                $item['Retirement Age'] = FinanceUtils::$retirement_age . 'yr';
                $item['Monthly Basic'] = (float)$salary->basic_salry;
                $item['Growth'] = $salary->grwth_rt . '%';

                $item['Employee Contribution'] = $epfAsset->employe_contrb . '%';
                $item['Employer Contribution'] = $epfAsset->employr_contrb . '%';
                $item['EPF Balance'] = (float)$epfAsset->accmultd_value;
                $item['Interest Rate'] = FinanceUtils::$epf_interest_rate . '%';
            
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
            $curr_age = (int)$record['Current Age'];
            $retire_age = (int)$record['Retirement Age'];
            $sal_growth = (float)$record['Growth'];
            $employe_contrib = (float)$record['Employee Contribution'];
            $employr_contrib = (float)$record['Employer Contribution'];
            $interest_rate = (float)$record['Interest Rate'];

            $start = $curr_age;
            $end = $retire_age;

            $growth_rate = 1 + $sal_growth / 100;
            $annual_salary = $record['Monthly Basic'] * 12;
            $employee_contrib = ($employe_contrib > 0)? (1 + $employe_contrib / 100) : 0;
            $employer_contrib = ($employr_contrib > 0)? (1 + $employr_contrib / 100) : 0;
            $epf_balance = $record['EPF Balance'];
            $epf_interest = 1 + $interest_rate / 100;

            $data[$key] = ['epf_data' => [], 'epf_report' => []];

            $final_balance = 0;
            for($i=1; $i <= ($end - $start); $i++)
            {
                $item = array();
                $item['Age'] = $start + $i . 'yrs';
                $item['Annual Salary'] = $annual_salary * $growth_rate;
            
                $annual_salary = $item['Annual Salary'];
                $own_contribution = $annual_salary * $employee_contrib;
                $company_contribution = $annual_salary * $employer_contrib;
                $item['Own Contribution'] = $own_contribution;
                $item['Company Contribution'] = $company_contribution;

                $total_balance = $epf_balance + $own_contribution + $company_contribution;
                $item['Total Balance'] = $total_balance;

                $final_balance = $total_balance * $epf_interest;                
                $item['Balance+Interest'] = $final_balance;

                $epf_balance = $total_balance;

                array_push($data[$key]['epf_report'], $item);
            }
                
            $record['Value at Retirement'] = $final_balance;
            $data[$key]['epf_data'] = $record;
        }

        return $data;
    }

}