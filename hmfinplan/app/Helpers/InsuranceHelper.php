<?php

namespace App\Helpers;

use App\Models\Customer;

class InsuranceHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getInsuranceCover()
    {
        $insurances = $this->customer->insurances;

        $total = 0;
        foreach($insurances as $insurance)
        {
            if($insurance['polcy_typ'] != 'Medical')
            {
                $total += $insurance['maturity_val'];
            }
        }

        $data['Total'] = $total;

        return $data;
    }
}