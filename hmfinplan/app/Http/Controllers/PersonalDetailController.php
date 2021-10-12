<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PersonalDetail;
use App\Http\Requests\PersonalDetailRequest;
use Barryvdh\Debugbar\Facade as Debugbar;

class PersonalDetailController extends Controller
{
    public function index(Customer $customer)
    {
        $personalDetail = $customer->personalDetail;

        if(request()->query('json')){
            return response()->json(['customer' => $customer, 'personalDetail' => $personalDetail], 200);
        }

        $current = 'personal';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(PersonalDetailRequest $request, Customer $customer)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        $others = $request->except($validated);
        $data = array_merge($validated, $others);
        Debugbar::info("store:", $data);
        $personalDetail = $customer->personalDetail()->create($data);


        // Debugbar::info($personalDetail);
        return $personalDetail;
    }
    
    public function update(PersonalDetailRequest $request, Customer $customer, PersonalDetail $personal)
    {
        Debugbar::info("update:", $personal);
        // Retrieve the validated input data...
        $validated = $request->validated();
        $others = $request->except($validated);
        $data = array_merge($validated, $others);
        $personalDetail = $personal->update($data);

        return $personalDetail;
    }
    
    public function destroy(Customer $customer, PersonalDetail $personal)
    {
        Debugbar::info("delete:", $personal);
        $personal->delete();
    }
}
