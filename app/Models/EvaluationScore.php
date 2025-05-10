<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'rubric_criteria_id',
        'score',
        'comments',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function rubricCriterion()
    {
        return $this->belongsTo(RubricCriterion::class, 'rubric_criteria_id');
    }
}
