<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RubricCriterion extends Model
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

    /**
     * Get the evaluation phase that owns the rubric criterion.
     */
    public function evaluationPhase(): BelongsTo
    {
        return $this->belongsTo(EvaluationPhase::class);
    }

    /**
     * Scope a query to only include active rubric criteria.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 