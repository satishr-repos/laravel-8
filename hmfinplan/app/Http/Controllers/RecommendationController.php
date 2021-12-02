<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Recommendation;
use Barryvdh\Debugbar\Facade as Debugbar;

class RecommendationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'content' => 'string|nullable|max:65535',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $recommendation = $customer->recommendation;

        if(request()->query('json')){
            return response()->json(compact('recommendation'), 200);
        }

        $current = 'Financial Plan';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        $recommendation = $customer->recommendation()->create($data);

        return $recommendation;
    }
    
    public function update(Request $request, Customer $customer, Recommendation $recommendation)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $recommendation->update($data);

        return $recommendation;
    }
    
    public function destroy(Customer $customer, Recommendation $recommendation)
    {
        $recommendation->delete();
    }
}
