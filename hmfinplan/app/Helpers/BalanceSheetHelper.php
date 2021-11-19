<?php

namespace App\Helpers;

use App\Models\Customer;
use DateTime;

class BalanceSheetHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    private function isShortTerm($duration)
    {
        // less than a year
        if($duration < 13)
            return true;

        return false;
    }

    public function getLiabilities()
    {
        $liabilities = $this->customer->liabilities->groupBy('loan_typ');

        $short_total = 0;
        $long_total = 0;

        $data['Short Term'] = array();
        $data['Long Term'] = array();
        foreach($liabilities as $key=>$liability)
        {
            $short = 0;
            $long = 0;
            
            for ($x = 0; $x < count($liability); $x++) 
            {
                if ($this->isShortTerm(($liability[$x]['duration']))) 
                {
                    $short += $liability[$x]['amt_outstanding']; 
                }
                else
                {
                    $long += $liability[$x]['amt_outstanding']; 
                }
            }
           
            if ($short != 0)
            {
                $data['Short Term'][$key] = $short;
                $short_total += $short;
            }

            if($long != 0)
            {
                $data['Long Term'][$key] = $long;
                $long_total += $long;
            }
        }

        // $data['Short Term']['Total'] = round($short_total,2);
        // $data['Long Term']['Total'] = round($long_total,2);
        $data['Net Worth'] = 0;
        $data['Total'] = round($short_total + $long_total,2);

        return $data;
    }
    
    public function getBankAssets()
    {
        $banks = $this->customer->bankAssets;
       
        $value = $banks->sum('curr_bal');
       
        return round($value, 2);
    }
    
    public function getFixedAssets()
    {
        $fixed = $this->customer->fixedAssets;
       
        $value = $fixed->sum('invest_amt');
       
        return round($value, 2);
    }
    
    public function getInvestmentAssets()
    {
        $investment = $this->customer->investmentAssets;
       
        $value = $investment->sum('currnt_val');
       
        return round($value, 2);
    }
    
    public function getRetirementAssets()
    {
        $retirement = $this->customer->retirementAssets;
       
        $value = $retirement->sum('accmultd_value');
       
        return round($value, 2);
    }

    public function getRealEstates()
    {
        $realEstate = $this->customer->realEstate;
       
        $value = $realEstate->sum('current_val');
       
        return round($value, 2);
    }
    
    public function getPersonalAssets()
    {
        $personal = $this->customer->personalItem;
       
        $value = $personal->sum('current_val');
       
        return round($value, 2);
    }

    public function getAssets()
    {
        $data['Tangible Assets'] = array();
        $data['Financial Assets'] = array();
        $data['Tangible Assets']['Real Estate'] = $this->getRealEstates();
        $data['Tangible Assets']['Personal Items'] = $this->getPersonalAssets();
        $tangible = array_sum($data['Tangible Assets']);
        $data['Financial Assets']['Bank Balance'] = $this->getBankAssets();
        $data['Financial Assets']['Fixed Deposits'] = $this->getFixedAssets();
        $data['Financial Assets']['Investments'] = $this->getInvestmentAssets();
        $data['Financial Assets']['Retirement Asset'] = $this->getRetirementAssets();
        $financial = array_sum($data['Financial Assets']);
        $data['Total'] = round($tangible + $financial, 2);

        return $data;
    }

    public function report()
    {
        $liabilities = $this->getLiabilities();
        $assets = $this->getAssets();
       
        $net_worth = $assets['Total'] - $liabilities['Total'];
        $liabilities['Net Worth'] = round($net_worth, 2);
        $liabilities['Total'] += $liabilities['Net Worth'];

        return compact('liabilities', 'assets');
    }

}
