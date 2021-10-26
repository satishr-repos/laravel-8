<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessAnswer extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function questions()
    {
        return $this->belongsToMany(RiskAssessQuestion::class, 'risk_assess_answer_question');
    }
}
