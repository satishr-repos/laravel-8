<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class PersonalDetailController extends Controller
{
    public function index(Customer $customer)
    {
        // $personalDetails = $customer->personalDetails();
        
        // if(request()->query('json')){
        //     return $personalDetails;
        // }

        $current = 'personal';

        // return View('customer.show', compact('customer', 'personalDetails', 'current'));
        return View('customer.show', compact('customer', 'current'));
    }

}
