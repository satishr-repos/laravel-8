<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\FixedAsset;
use Barryvdh\Debugbar\Facade as Debugbar;

class FixedAssetController extends Controller
{
    private function verify(Request $request)
    {
        $data = request()->validate([
                'acct_nbr' => 'alpha_num|nullable',
                'acct_desc' => 'string|nullable',
                'acct_typ' => 'alpha|nullable',
                'intrst_rt' => 'numeric|nullable',
                'compound' => 'numeric|nullable',
                'invest_amt' => 'numeric|nullable',
                'invest_yr' => 'date|nullable',
                'maturity_amt' => 'numeric|nullable',
                'maturity_yr' => 'date|nullable',
                'status' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $fixedAsset = $customer->fixedAssets;

        if(request()->query('json')){
            return response()->json(compact('fixedAsset'), 200);
        }

        $current = 'assets';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $fixedAsset = $customer->fixedAssets()->create($data);

        return $fixedAsset;
    }
    
    public function update(Request $request, Customer $customer, FixedAsset $fixedAsset)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $fixedAsset->update($data);
        Debugbar::info("update:", $fixedAsset);

        return $fixedAsset;
    }
    
    public function destroy(Customer $customer, FixedAsset $fixedAsset)
    {
        Debugbar::info("delete:", $fixedAsset);
        $fixedAsset->delete();
    }
}
