<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'active'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the personal details associated with the customer.
     */
    public function personalDetail()
    {
        return $this->hasOne(PersonalDetail::class);
    }
    
    /**
     * Get the family members associated with the customer.
     */
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    /**
     * Get the family members associated with the customer.
     */
    public function professionalDetails()
    {
        return $this->hasMany(ProfessionalDetails::class);
    }
    
    /**
     * Get the real estate associated with the customer.
     */
    public function realEstate()
    {
        return $this->hasMany(RealEstate::class);
    }
    
    /**
     * Get the personal items associated with the customer.
     */
    public function personalItem()
    {
        return $this->hasMany(PersonalItem::class);
    }
    
    /**
     * Get the bank accounts associated with the customer.
     */
    public function bankAssets()
    {
        return $this->hasMany(BankAsset::class);
    }
}
