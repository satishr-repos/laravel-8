<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\PensionIncome;
use Barryvdh\Debugbar\Facade as Debugbar;

class PensionIncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'pension_plan' => 'string|nullable',
                'annul_inc' => 'numeric|nullable',
                'strt_yr' => 'date|nullable',
                'end_yr' => 'date|nullable',
                'grwth_rt' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $pensionIncome = $customer->pensionIncomes;

        if(request()->query('json')){
            return response()->json(compact('pensionIncome'), 200);
        }

        $current = 'incomes';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $pensionIncome = $customer->pensionIncomes()->create($data);

        return $pensionIncome;
    }
    
    public function update(Request $request, Customer $customer, PensionIncome $pensionIncome)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $pensionIncome->update($data);
        Debugbar::info("update:", $pensionIncome);

        return $pensionIncome;
    }
    
    public function destroy(Customer $customer, PensionIncome $pensionIncome)
    {
        Debugbar::info("delete:", $pensionIncome);
        $pensionIncome->delete();
    }
}
