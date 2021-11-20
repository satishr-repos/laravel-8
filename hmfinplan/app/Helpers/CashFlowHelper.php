<?php

namespace App\Helpers;

use App\Models\Customer;
use DateTime;

class CashFlowHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function investment()
    {
        $ieHelper = new IncomeExpenseHelper($this->customer);
        $report = $ieHelper->report();

        $mfInvestment = 0;
        $proposed = 0;
        $total = 0;

        $search = Utils::array_search_id('Mutual Funds', $report, array());
        if($search !== null)
        {
            $result = $report;
            for($i=0; $i < (count($search) - 1); $i++)
            {
                $result = $result[$search[$i]];
            }

            $mfInvestment = $result['Annual'] ?? 0;
        }    

        $proposed = $report['outflow']['Proposed Investment']['Annual'] ?? 0;
        $total = $proposed + $mfInvestment;

        return $total;
    }

    public function cash_flow_data()
    {
        $bsHelper = new BalanceSheetHelper($this->customer);
        $goalsHelper = new GoalsHelper($this->customer);

        $now = new DateTime($this->customer->updated_at);
        $year = $now->format('Y');

        $dob = new DateTime($this->customer->personalDetail->dob);
        $age = $now->diff($dob)->y;

        $data['Age'] = $age;
        $data['Year'] = $year;
        $data['Opening Balance'] = $bsHelper->getInvestmentAssets();
        $data['Investments'] = $this->investment();

        $end_of_year = new DateTime($year.'-12-31');
        $data['Remaining Months'] = $now->diff($end_of_year)->m;

        $goals = $goalsHelper->report();
        $data['Cash Outflow'] = array_column($goals, 4, 2);

        return $data;
    }

    public function report()
    {
        $cf_data =  $this->cash_flow_data();

        $age = $cf_data['Age'];
        $end = FinanceUtils::$retirement_age - $age + 1;
        $exp_returns = array_merge(array(0.03, -0.10, 0.03, 0.18), array_fill(4, $end, FinanceUtils::$cash_flow_cagr));

        $year = $cf_data['Year'];
        $opening = $cf_data['Opening Balance'];
        $investments = $cf_data['Investments'];
        $share_of_investment = $cf_data['Remaining Months'] / 12;

        $goal_outflow = $cf_data['Cash Outflow'];

        $total_investments = 0;
        $total_returns = 0;
        $total_outflow = 0;

        $data = array();
        for($i=0; $i < $end; $i++)
        {
            $item = array();
            $item['Age'] = (string)$age;
            $item['Year'] = (string)$year;
            $item['Opening Balance'] = $opening;
            $item['Investments'] = $investments * $share_of_investment;

            $subtotal1 = $opening + ($investments * $share_of_investment);
            $item['Subtotal1'] = $subtotal1;

            $returns = $subtotal1 * $exp_returns[$i];
            $item['Returns'] = $returns;

            $subtotal2 = $subtotal1 + $returns;
            $item['Subtotal2'] = $subtotal2;

            $cash_outflow = $goal_outflow[$year] ?? 0;
            if($i == $end - 1)
                $cash_outflow += $subtotal2;

            $item['Cash Outflow'] = $cash_outflow;

            $closing = $subtotal2 - $cash_outflow;
            $item['Closing Balance'] = $closing;

            $age++;
            $year++;
            $opening = $closing;
            $share_of_investment = 1;

            $total_investments += $item['Investments'];
            $total_returns += $returns;
            $total_outflow += $cash_outflow;

            array_push($data, $item);
        }
       
        array_push($data, array('', '', 'Total', $total_investments, '', $total_returns, '', $total_outflow, ''));
        
        return $data;
    }
}