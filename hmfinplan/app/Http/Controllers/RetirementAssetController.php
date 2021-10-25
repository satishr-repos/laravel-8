<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\RetirementAsset;
use Barryvdh\Debugbar\Facade as Debugbar;


class RetirementAssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'acct_typ'  => 'alpha|nullable',
                'employe_contrb' => 'numeric|nullable',
                'employr_contrb' => 'numeric|nullable',
                'accmultd_value' => 'numeric|nullable',
                'strt_yr' => 'date|nullable',
                'end_yr' => 'date|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $retirementAsset = $customer->retirementAssets;

        if(request()->query('json')){
            return response()->json(compact('retirementAsset'), 200);
        }

        $current = 'assets';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $retirementAsset = $customer->retirementAssets()->create($data);

        return $retirementAsset;
    }
    
    public function update(Request $request, Customer $customer, RetirementAsset $retirementAsset)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $retirementAsset->update($data);
        Debugbar::info("update:", $retirementAsset);

        return $retirementAsset;
    }
    
    public function destroy(Customer $customer, RetirementAsset $retirementAsset)
    {
        Debugbar::info("delete:", $retirementAsset);
        $retirementAsset->delete();
    }
}
