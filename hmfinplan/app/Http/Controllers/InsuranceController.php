<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Insurance;
use Barryvdh\Debugbar\Facade as Debugbar;

class InsuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'polcy_typ' => 'string|nullable',
                'insurnce_cmpny' => 'string|nullable',
                'polcy_name' => 'string|nullable',
                'polcy_nbr' => 'alpha_num|nullable',
                'insuree_name' => 'regex:/^[a-z ]+$/i|nullable',
                'polcy_start_dt' => 'date|nullable',
                'polcy_end_dt' => 'date|nullable',
                'sum_insurd' => 'numeric|nullable',
                'annul_prmium' => 'numeric|nullable',
                'maturity_val' => 'numeric|nullable',
                'prmium_mode' => 'string|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $insurance = $customer->insurances;

        $familyMembers = array($customer->first_name . ' ' . $customer->last_name);

        foreach($customer->familyMembers as $family)
        {
            array_push($familyMembers, $family->first_name . ' ' . $family->last_name);
        }

        if(request()->query('json')){
            return response()->json(compact('insurance', 'familyMembers'), 200);
        }

        $current = 'insurances';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $insurance = $customer->insurances()->create($data);

        return $insurance;
    }
    
    public function update(Request $request, Customer $customer, Insurance $insurance)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $insurance->update($data);
        Debugbar::info("update:", $insurance);

        return $insurance;
    }
    
    public function destroy(Customer $customer, Insurance $insurance)
    {
        Debugbar::info("delete:", $insurance);
        $insurance->delete();
    }
}
