<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class PersonalDetailController extends Controller
{
    public function index(Customer $customer)
    {
        $personalDetails = $customer->personalDetails;

        if(request()->query('json')){
            return response()->json(['customer' => $customer, 'personalDetails' => $personalDetails], 200);
        }

        $current = 'personal';

        return View('customer.show', compact('customer', 'current'));
    }

}
