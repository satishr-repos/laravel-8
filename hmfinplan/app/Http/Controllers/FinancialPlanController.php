<?php

namespace App\Http\Controllers;

use App\Helpers\BalanceSheetHelper;
use App\Helpers\CashFlowHelper;
use App\Helpers\EpfHelper;
use App\Helpers\GoalsHelper;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Helpers\IncomeExpenseHelper;
use App\Helpers\LivingExpensesHelper;
use App\Helpers\RiskManagementHelper;

class FinancialPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Customer $customer)
    {
        $current = 'Financial Plan';

        return View('customer.show', compact('customer', 'current'));
    }

    public function IncomeAndExpense(Customer $customer)
    {
        $ieHelper = new IncomeExpenseHelper($customer);
       
        if(request()->query('expense')){
            $expense = $ieHelper->getExpenses();
            return $expense;
        }
        
        if(request()->query('income')){
            $income = $ieHelper->getIncomes();
            return $income;
        }

        $iereport = $ieHelper->report();

        return response()->json(compact('iereport'), 200);
    }

    public function Goals(Customer $customer)
    {
        $goalsHelper = new GoalsHelper($customer);
       
        $goalsreport = $goalsHelper->report();

        return response()->json(compact('goalsreport'), 200);
    }

    public function BalanceSheet(Customer $customer)
    {
        $bsHelper = new BalanceSheetHelper($customer);

        $balancesheet = $bsHelper->report();

        return response()->json(compact('balancesheet'), 200);
    }

    public function RiskManagement(Customer $customer)
    {
        $riskHelper = new RiskManagementHelper($customer);

        $riskmgmt = $riskHelper->report();

        return response()->json(compact('riskmgmt'), 200);
    }

    public function LivingExpenses(Customer $customer)
    {
        $livingHelper = new LivingExpensesHelper($customer);

        $livingexpenses = $livingHelper->report();

        return response()->json(compact('livingexpenses'), 200);
    }

    public function EpfReport(Customer $customer)
    {
        $epfHelper = new EpfHelper($customer);

        $epfreport = $epfHelper->report();

        return response()->json(compact('epfreport'), 200);
    }
    
    public function CashFlowReport(Customer $customer)
    {
        $cashFlowHelper = new CashFlowHelper($customer);

        $cashflow = $cashFlowHelper->report();

        return response()->json(compact('cashflow'), 200);
    }
}
