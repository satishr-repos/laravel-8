<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\FamilyMember;
use Barryvdh\Debugbar\Facade as Debugbar;

class FamilyMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'first_name' => 'alpha|nullable',
                'middle_name' => 'alpha|nullable',
                'last_name' => 'alpha|nullable',
                'salutation' => 'string|nullable',
                'relation' => 'alpha|required',
                'dob' => 'date|nullable',
                'pan' => ['regex:/[A-Za-z]{5}[0-9]{4}[A-Za-z]/u', 'nullable'],
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $familyMembers = $customer->familyMembers;

        if(request()->query('json')){
            return response()->json(['familyMembers' => $familyMembers], 200);
        }

        $current = 'personal';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $family = $customer->familyMembers()->create($data);

        return $family;
    }
    
    public function update(Request $request, Customer $customer, FamilyMember $family)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $family->update($data);
        Debugbar::info("update:", $family);

        return $family;
    }
    
    public function destroy(Customer $customer, FamilyMember $family)
    {
        Debugbar::info("delete:", $family);
        $family->delete();
    }
}
