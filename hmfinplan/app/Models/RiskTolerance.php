<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskTolerance extends Model
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

    public function survey()
    {
        return $this->belongsTo(RiskAssessQuestion::class, 'question_id');
    }
    
    public function response()
    {
        return $this->belongsTo(RiskAssessAnswer::class, 'answer_id');
    }
}
