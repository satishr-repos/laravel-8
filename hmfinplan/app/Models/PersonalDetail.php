<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    use HasFactory;
 
    protected $guarded = [];
 
    /**
     * Get the customer of this personal details.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
