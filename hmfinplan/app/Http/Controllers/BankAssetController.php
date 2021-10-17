<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\BankAsset;
use Barryvdh\Debugbar\Facade as Debugbar;

class BankAssetController extends Controller
{
    private function verify(Request $request)
    {
        $data = request()->validate([
                'acct_typ' => 'alpha|nullable',
                'desc' => 'string|nullable',
                'acct_nbr' => 'string|nullable',
                'curr_bal' => 'numeric|nullable',
                'intrst_rt' => 'numeric|nullable',
                'status' => 'numeric|nullable',
            ]);

        return $data;
    }

    //
    public function index(Customer $customer)
    {
        $bank = $customer->bankAssets;

        if(request()->query('json')){
            return response()->json(compact('bank'), 200);
        }

        $current = 'assets';

        return View('customer.show', compact('customer', 'current'));
    }

    public function store(Request $request, Customer $customer)
    {
        $data = $this->verify($request);
        Debugbar::info("store:", $data);
        $bank = $customer->bankAssets()->create($data);

        return $bank;
    }
    
    public function update(Request $request, Customer $customer, BankAsset $bank)
    {
        $data = $this->verify($request);

        // Retrieve the validated input data...
        $bank->update($data);
        Debugbar::info("update:", $bank);

        return $bank;
    }
    
    public function destroy(Customer $customer, BankAsset $bank)
    {
        Debugbar::info("delete:", $bank);
        $bank->delete();
    }
}
