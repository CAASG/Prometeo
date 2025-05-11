<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationPhase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sequence_order',
        'weight',
        'is_active',
    ];

    protected $casts = [
        'sequence_order' => 'integer',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function criteria()
    {
        return $this->hasMany(RubricCriterion::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sequence_order');
    }
}
