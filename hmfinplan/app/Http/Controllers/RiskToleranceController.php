<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\RiskAssessQuestion;
use App\Models\RiskTolerance;
use Barryvdh\Debugbar\Facade as Debugbar;

class RiskToleranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function verify(Request $request)
    {
        $data = request()->validate([
                'survey' => 'required|array|min:10',
                'survey.*' => 'required|numeric',
                'response' => 'required|array|min:10',
                'response.*' => 'required|numeric',
            ]);

        return $data;
    }

    public function index(Customer $customer)
    {
        $riskTolerance = $customer->riskTolerances;

        $riskTolerance->load('survey', 'response');

        if(request()->query('json')){
            return response()->json(compact('riskTolerance'), 200);
        }
        
        if(request()->query('questionnaire')){
            $questionnaire = RiskAssessQuestion::with('answers')->get();
            return response()->json(compact('questionnaire'), 200);
        }

        $current = 'risks';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        $sqlData = [];
        for($i=0; $i < count($data['survey']); $i++) {
            $sqlData[$i] = array('question_id' => $data['survey'][$i], 
                                'answer_id' => $data['response'][$i]);
        }
        Debugbar::info("store:", $sqlData);

        $riskTolerance = $customer->riskTolerances()->createMany($sqlData);
        
        $riskTolerance->load('survey', 'response');
        return $riskTolerance;
    }
    
    public function update(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        $riskTolerance = $customer->riskTolerances;
        $sqlData = null;
        for($i=0; $i < count($data['survey']); $i++) {
            $sqlData = array('question_id' => $data['survey'][$i], 
                                'answer_id' => $data['response'][$i]);
            
            $riskTolerance[$i]->update($sqlData);
        }

        $riskTolerance->load('survey', 'response');
        // Retrieve the validated input data...
        Debugbar::info("update:", $riskTolerance);

        return $riskTolerance;
    }
    
    public function destroy(Customer $customer)
    {
        $riskTolerance = $customer->riskTolerances;

        Debugbar::info("delete:", $riskTolerance);

        RiskTolerance::destroy($riskTolerance->pluck('id'));
    }
}
