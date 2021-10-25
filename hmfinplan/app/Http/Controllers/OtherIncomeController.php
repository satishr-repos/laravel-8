<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\OtherIncome;
use Barryvdh\Debugbar\Facade as Debugbar;

class OtherIncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'inc_typ' => 'alpha_num|nullable',
                'inc_desc' => 'string|nullable',
                'annul_inc' => 'numeric|nullable',
                'inc_tx_rt' => 'numeric|nullable',
                'grwth_rt' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $otherIncome = $customer->otherIncomes;

        if(request()->query('json')){
            return response()->json(compact('otherIncome'), 200);
        }

        $current = 'incomes';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $otherIncome = $customer->otherIncomes()->create($data);

        return $otherIncome;
    }
    
    public function update(Request $request, Customer $customer, OtherIncome $otherIncome)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $otherIncome->update($data);
        Debugbar::info("update:", $otherIncome);

        return $otherIncome;
    }
    
    public function destroy(Customer $customer, OtherIncome $otherIncome)
    {
        Debugbar::info("delete:", $otherIncome);
        $otherIncome->delete();
    }
}
