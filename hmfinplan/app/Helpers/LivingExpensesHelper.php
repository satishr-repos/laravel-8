<?php

namespace App\Helpers;

use App\Models\Customer;
use Carbon\Carbon;
use DateTime;

class LivingExpensesHelper
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

        // $now = new DateTime(Carbon::now());
        $now = new DateTime($this->customer->updated_at);
        $dob = new DateTime($this->customer->personalDetail->dob ?? '');
        $data['Record Date'] = $now->format('d-F-Y');
        $data['Date Of Birth'] = $dob->format('d-F-Y');
        $age = $now->diff($dob)->y;
        $data['Record Age'] = $age . ' years';
        
        $data['Retirement Age'] = FinanceUtils::$retirement_age . ' years';
        
        $essential_expense = $expenses['Essential']['Annual'];
        $data['Current Expenses'] = $essential_expense;

        $time = FinanceUtils::$retirement_age - $age;
        $data['Time'] = $time . ' years';
        
        $data['Inflation'] = FinanceUtils::$inflation . '%';
        
        $future_exp = FinanceUtils::futureValue(FinanceUtils::$inflation, $time, $essential_expense);
        $data['Future Expense'] = round($future_exp, 2);

        $data['Life Expectancy'] = FinanceUtils::$life_expectancy . ' years';

        $pension_period = FinanceUtils::$life_expectancy - FinanceUtils::$retirement_age;
        $data['Years to Provide Pension'] = $pension_period . ' years';

        $data['Post Freedom Inflation'] = FinanceUtils::$post_freedom_inflation . '%';
        $data['Returns Expected'] = FinanceUtils::$post_freedom_returns . '%';
        $data['Tax'] = FinanceUtils::$post_freedom_tax_rate . '%';

        $post_tax_returns = FinanceUtils::$post_freedom_returns - 
                                (FinanceUtils::$post_freedom_inflation * FinanceUtils::$post_freedom_tax_rate / 100);
        $data['Post Tax Returns'] = $post_tax_returns . '%';

        $effective_returns = (1 + $post_tax_returns / 100) / (1 + FinanceUtils::$post_freedom_inflation / 100) - 1;
        $effective_returns = round($effective_returns * 100, 2); 
        $data['Effective Returns'] = $effective_returns . '%';

        $data['Corpus Required'] = FinanceUtils::presentValueAnnuity($future_exp, $effective_returns, $pension_period);

        return $data;
    }
}