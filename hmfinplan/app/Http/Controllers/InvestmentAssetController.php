<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\InvestmentAsset;
use Barryvdh\Debugbar\Facade as Debugbar;

class InvestmentAssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    private function verify(Request $request)
    {
        $data = request()->validate([
                'stk_typ' => 'alpha|nullable',
                'stk_dtl' => 'string|nullable',
                'isin_nbr' => ['regex:/[A-Z]{2}[0-9A-Z]{10}/u', 'nullable'],
                'units_held' => 'numeric|nullable',
                'purchse_cst' => 'numeric|nullable',
                'stamp_duty' => 'numeric|nullable',
                'currnt_val' => 'numeric|nullable',
                'status' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $investmentAsset = $customer->investmentAssets;

        if(request()->query('json')){
            return response()->json(compact('investmentAsset'), 200);
        }

        $current = 'Assets';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $investmentAsset = $customer->investmentAssets()->create($data);

        return $investmentAsset;
    }
    
    public function update(Request $request, Customer $customer, InvestmentAsset $investmentAsset)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $investmentAsset->update($data);
        Debugbar::info("update:", $investmentAsset);

        return $investmentAsset;
    }
    
    public function destroy(Customer $customer, InvestmentAsset $investmentAsset)
    {
        Debugbar::info("delete:", $investmentAsset);
        $investmentAsset->delete();
    }
}
