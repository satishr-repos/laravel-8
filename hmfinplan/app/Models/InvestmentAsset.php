<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentAsset extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    /**
     * Get the customer of this asset
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
