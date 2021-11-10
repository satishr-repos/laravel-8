<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Expense;
use Barryvdh\Debugbar\Facade as Debugbar;
use DebugBar\DebugBar as DebugBarDebugBar;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'exp_typ' => 'string|nullable',
                'exp_typ_sub' => 'string|nullable',
                'annul_exp' => 'numeric|nullable',
                'inflation' => 'numeric|nullable',
                'is_essential' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $expense = $customer->expenses;
        $expense = $expense->sortBy('exp_typ')->values()->all();
        // DebugBar::info($expense);

        if(request()->query('json')){
            return response()->json(compact('expense'), 200);
        }

        $current = 'expenses';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $expense = $customer->expenses()->create($data);

        return $expense;
    }
    
    public function update(Request $request, Customer $customer, Expense $expense)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $expense->update($data);
        Debugbar::info("update:", $expense);

        return $expense;
    }
    
    public function destroy(Customer $customer, Expense $expense)
    {
        Debugbar::info("delete:", $expense);
        $expense->delete();
    }
}
