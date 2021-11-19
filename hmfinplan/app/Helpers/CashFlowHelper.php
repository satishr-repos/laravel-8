<?php

namespace App\Helpers;

use App\Models\Customer;
use DateTime;

class CashFlowHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}