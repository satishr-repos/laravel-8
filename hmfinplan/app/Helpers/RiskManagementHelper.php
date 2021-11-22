<?php

namespace App\Helpers;

use App\Models\Customer;

class RiskManagementHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function report()
    {
        $ieHelper = new IncomeExpenseHelper($this->customer);
        $expenses = $ieHelper->getExpenses();

        $goalsHelper = new GoalsHelper($this->customer);
        $bsHelper = new BalanceSheetHelper($this->customer);
        $liabilities = $bsHelper->getLiabilities();

        $data['Name'] = $this->customer->first_name . ' ' . $this->customer->last_name;
        $data['Date Of Birth'] = $this->customer->personalDetail->dob ?? '';

        $essential_expense = $expenses['Essential']['Annual'];
        $data['Annual Living Cost'] = $essential_expense;

        $rate = FinanceUtils::$savings_rate / 100;
        $capital_reqd = $essential_expense / $rate;
        $data['Capital Required to replace the cost at ' . FinanceUtils::$savings_rate . '%' ] = $capital_reqd;

        $child_goals = $goalsHelper->childGoals();
        $data['Child Goals'] = $child_goals;

        $liability_total = $liabilities['Total'];
        $data['Outstanding Loans'] = $liabilities['Total'];

        $total = $capital_reqd + $child_goals + $liability_total;
        $data['Total(5+6+7)'] = $total;

        $insHelper = new InsuranceHelper($this->customer);
        $riskCover = $insHelper->getInsuranceCover();
        $investments = $bsHelper->getInvestmentAssets() + $bsHelper->getRetirementAssets();

        $riskCoverage = $riskCover['Total'] + $investments;
        $data['Insurance + Investments'] = round($riskCoverage, 2);
        $data['Insurance Needs'] = round($total - $riskCoverage, 2);

        $report['Risk Management'] = $data;

        $info['Risk Cover'] = $riskCover['Total'];
        $info['Invesment Value'] = round($investments,2);
        $info['Total Insurance + Invesments'] = $riskCover['Total'] + $investments; 

        $report['Available Resources'] = $info;

        return $report;
    }
}