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
}
