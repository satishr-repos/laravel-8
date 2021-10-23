<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SalaryIncome;
use Barryvdh\Debugbar\Facade as Debugbar;

class SalaryIncomeController extends Controller
{
    private function verify(Request $request)
    {
        $data = request()->validate([
                'gross_salry' => 'numeric|nullable',
                'net_salry' => 'numeric|nullable',
                'grwth_rt' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $salaryIncome = $customer->salaryIncomes;

        if(request()->query('json')){
            return response()->json(compact('salaryIncome'), 200);
        }

        $current = 'incomes';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $salaryIncome = $customer->salaryIncomes()->create($data);

        return $salaryIncome;
    }
    
    public function update(Request $request, Customer $customer, SalaryIncome $salaryIncome)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $salaryIncome->update($data);
        Debugbar::info("update:", $salaryIncome);

        return $salaryIncome;
    }
    
    public function destroy(Customer $customer, SalaryIncome $salaryIncome)
    {
        Debugbar::info("delete:", $salaryIncome);
        $salaryIncome->delete();
    }
}
