<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Goal;
use Barryvdh\Debugbar\Facade as Debugbar;

class GoalController extends Controller
{
    private function verify(Request $request)
    {
        $data = request()->validate([
                'goal_typ' => 'string|required',
                'goal_desc' => 'string|nullable',
                'goal_start_dt' => 'date|nullable',
                'goal_target_dt' => 'date|nullable',
                'current_saving' => 'numeric|nullable',
                'goal_pri' => 'alpha|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $goal = $customer->goals;

        if(request()->query('json')){
            return response()->json(compact('goal'), 200);
        }

        $current = 'goals';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $goal = $customer->goals()->create($data);

        return $goal;
    }
    
    public function update(Request $request, Customer $customer, Goal $goal)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $goal->update($data);
        Debugbar::info("update:", $goal);

        return $goal;
    }
    
    public function destroy(Customer $customer, Goal $goal)
    {
        Debugbar::info("delete:", $goal);
        $goal->delete();
    }
}
