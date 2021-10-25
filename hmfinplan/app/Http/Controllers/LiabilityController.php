<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Liability;
use Barryvdh\Debugbar\Facade as Debugbar;

class LiabilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'loan_typ' => 'alpha|nullable',
                'fin_inst' => 'string|nullable',
                'amt_outstanding' => 'numeric|nullable',
                'emi' => 'numeric|nullable',
                'inrst_rt' => 'numeric|nullable',
                'start_yr' => 'date|nullable',
                'duration' => 'numeric|nullable',
                'status' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $liability = $customer->liabilities;

        if(request()->query('json')){
            return response()->json(compact('liability'), 200);
        }

        $current = 'liabilities';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $liability = $customer->liabilities()->create($data);

        return $liability;
    }
    
    public function update(Request $request, Customer $customer, Liability $liability)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $liability->update($data);
        Debugbar::info("update:", $liability);

        return $liability;
    }
    
    public function destroy(Customer $customer, Liability $liability)
    {
        Debugbar::info("delete:", $liability);
        $liability->delete();
    }
}
