<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\FamilyMember;
use App\Models\ProfessionalDetails;
use Barryvdh\Debugbar\Facade as Debugbar;

class ProfessionalDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'name' => 'regex:/^[a-z ]+$/i|nullable',
                'title' => 'string|required',
                'employer' => 'string|nullable',
                'education' => 'string|nullable',
                'preferred_time' => 'string|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $profession = $customer->ProfessionalDetails;
        $family = $customer->familyMembers;

        if(request()->query('json')){
            return response()->json(compact('customer', 'family', 'profession'), 200);
        }

        $current = 'personal';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $profession = $customer->professionalDetails()->create($data);

        return $profession;
    }
    
    public function update(Request $request, Customer $customer, ProfessionalDetails $profession)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $profession->update($data);
        Debugbar::info("update:", $profession);

        return $profession;
    }
    
    public function destroy(Customer $customer, ProfessionalDetails $profession)
    {
        Debugbar::info("delete:", $profession);
        $profession->delete();
    }
}
