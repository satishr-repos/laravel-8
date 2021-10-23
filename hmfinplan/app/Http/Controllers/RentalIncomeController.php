<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\RentalIncome;
use Barryvdh\Debugbar\Facade as Debugbar;

class RentalIncomeController extends Controller
{
    private function verify(Request $request)
    {
        $data = request()->validate([
                'annul_inc' => 'numeric|nullable',
                'grwth_rt' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $rentalIncome = $customer->rentalIncomes;

        if(request()->query('json')){
            return response()->json(compact('rentalIncome'), 200);
        }

        $current = 'incomes';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $rentalIncome = $customer->rentalIncomes()->create($data);

        return $rentalIncome;
    }
    
    public function update(Request $request, Customer $customer, RentalIncome $rentalIncome)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $rentalIncome->update($data);
        Debugbar::info("update:", $rentalIncome);

        return $rentalIncome;
    }
    
    public function destroy(Customer $customer, RentalIncome $rentalIncome)
    {
        Debugbar::info("delete:", $rentalIncome);
        $rentalIncome->delete();
    }
}
