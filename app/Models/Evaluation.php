<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'evaluator_id',
        'evaluation_phase_id',
        'total_score',
        'comments',
        'is_completed',
        'evaluation_date',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'is_completed' => 'boolean',
        'evaluation_date' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function evaluationPhase()
    {
        return $this->belongsTo(EvaluationPhase::class);
    }

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class);
    }

    public function calculateTotalScore()
    {
        $totalScore = $this->scores()->sum('score');
        $this->update(['total_score' => $totalScore]);
        return $totalScore;
    }
}
