<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facade as Debugbar;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pageSize = request()->query('pageSize', 10); 

        // $customers = Customer::select('id', DB::raw("CONCAT(first_name,' ', last_name) AS display_name"))
        //                 ->where('active', 1)
        //                 ->orderBy('first_name')
        //                 ->paginate($pageSize);

        $customers = Customer::select('id', 'first_name', 'middle_name', 'last_name', 'active')
                            ->orderBy('first_name')
                            ->paginate($pageSize);
        
        if(request()->query('json')){
            return $customers;
        }

        return View('customer.index');
    }

    public function store()
    {
        $data = request()->validate([
             'first_name' => 'required|alpha',
             'middle_name' => 'alpha|nullable',
             'last_name' => 'required|alpha',
             'active' => 'boolean'
            ]);
      
        // return response()->json([
        //     'formdata' => $data,
        //     'message' => 'Success'
        //   ], 200);
        
        $customer = Customer::create($data);
        
        return $customer;
    }

    public function show(Customer $customer)
    {
        // return response()->json([
        //     'formdata' => $data,
        //     'message' => 'Success'
        //   ], 200);
       
        $current = 'dashboard';
        
        return View('customer.show', compact('customer', 'current'));
    }

    public function update(Customer $customer)
    {
        $data = request()->validate([
             'first_name' => 'required|alpha',
             'middle_name' => 'alpha|nullable',
             'last_name' => 'required|alpha',
             'active' => 'boolean'
            ]);
      
        // return response()->json([
        //     'formdata' => $data,
        //     'message' => 'Success'
        //   ], 200);
          
        $customer->update($data);

        return $customer;
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
    }
}
