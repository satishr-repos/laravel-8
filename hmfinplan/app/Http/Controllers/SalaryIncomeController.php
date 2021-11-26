<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SalaryIncome;
use Barryvdh\Debugbar\Facade as Debugbar;

class SalaryIncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'gross_salry' => 'numeric|required',
                'net_salry' => 'numeric|required',
                'basic_salry' => 'numeric|required',
                'grwth_rt' => 'numeric|nullable',
                'retirement_asset_id' => 'nullable|exists:retirement_assets,id',
                'family_member_id' => 'nullable|exists:family_members,id'
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $salaryIncome = $customer->salaryIncomes;

        if(request()->query('json')){
            return response()->json(compact('customer', 'salaryIncome'), 200);
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
