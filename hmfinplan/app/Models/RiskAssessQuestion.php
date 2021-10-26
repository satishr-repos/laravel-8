<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessQuestion extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function answers()
    {
        return $this->belongsToMany(RiskAssessAnswer::class, 'risk_assess_answer_question');
    }
}
