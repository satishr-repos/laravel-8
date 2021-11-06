<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\PersonalItem;
use Barryvdh\Debugbar\Facade as Debugbar;

class PersonalItemController extends Controller
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
                'status' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $personalItem = $customer->personalItem;

        if(request()->query('json')){
            return response()->json(compact('personalItem'), 200);
        }

        $current = 'Tangible Assets';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $personalItem = $customer->personalItem()->create($data);

        return $personalItem;
    }
    
    public function update(Request $request, Customer $customer, PersonalItem $personalItem)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $personalItem->update($data);
        Debugbar::info("update:", $personalItem);

        return $personalItem;
    }
    
    public function destroy(Customer $customer, PersonalItem $personalItem)
    {
        Debugbar::info("delete:", $personalItem);
        $personalItem->delete();
    }
}
