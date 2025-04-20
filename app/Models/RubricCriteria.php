<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubricCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_phase_id',
        'name',
        'description',
        'max_score',
        'is_active',
    ];

    protected $casts = [
        'max_score' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function evaluationPhase()
    {
        return $this->belongsTo(EvaluationPhase::class);
    }

    public function evaluationScores()
    {
        return $this->hasMany(EvaluationScore::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
