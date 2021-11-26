<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryIncome extends Model
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

    public function retirementAsset()
    {
        return $this->belongsTo(RetirementAsset::class);
    }
    
    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
