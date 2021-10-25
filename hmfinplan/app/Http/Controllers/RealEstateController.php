<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\RealEstate;
use Barryvdh\Debugbar\Facade as Debugbar;

class RealEstateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'type' => 'alpha|nullable',
                'desc' => 'string|nullable',
                'purchase_yr' => 'date|nullable',
                'purchase_cost' => 'numeric|nullable',
                'expct_growth_rt' => 'numeric|nullable',
                'current_val' => 'numeric|nullable',
                'area' => 'string|nullable',
                'status' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $realEstate = $customer->realEstate;

        if(request()->query('json')){
            return response()->json(compact('realEstate'), 200);
        }

        $current = 'assets';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $realEstate = $customer->realEstate()->create($data);

        return $realEstate;
    }
    
    public function update(Request $request, Customer $customer, RealEstate $realestate)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $realestate->update($data);
        Debugbar::info("update:", $realestate);

        return $realestate;
    }
    
    public function destroy(Customer $customer, RealEstate $realestate)
    {
        Debugbar::info("delete:", $realestate);
        $realestate->delete();
    }
}
