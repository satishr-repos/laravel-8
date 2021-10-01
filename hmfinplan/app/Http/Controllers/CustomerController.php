<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $pageSize = request()->query('pageSize', 10); 

        $customers = Customer::select('id', DB::raw("CONCAT(first_name,' ', last_name) AS display_name"))
                        ->where('active', 1)
                        ->orderBy('first_name')
                        ->paginate($pageSize);

        if(request()->query('json')){
            return $customers;
        }

        return View('customer.index');
    }
}
