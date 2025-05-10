<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'project_category_id',
        'project_status_id',
        'submission_date',
        'deadline_for_corrections',
        'final_score',
        'created_by'
    ];

    protected $casts = [
        'submission_date' => 'date',
        'deadline_for_corrections' => 'date',
        'final_score' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function themes()
    {
        return $this->belongsToMany(ProjectTheme::class, 'project_themes_map', 'project_id', 'project_theme_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'project_participants')
            ->withPivot('is_director')
            ->withTimestamps();
    }

    public function director()
    {
        return $this->belongsToMany(User::class, 'project_participants')
            ->wherePivot('is_director', true);
    }

    public function documents()
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(ProjectStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function evaluators()
    {
        return $this->belongsToMany(User::class, 'project_evaluators', 'project_id', 'evaluator_id')
            ->withPivot('assigned_by', 'assigned_date')
            ->withTimestamps();
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function presentation()
    {
        return $this->hasOne(Presentation::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function writtenEvaluations()
    {
        return $this->hasMany(Evaluation::class)
            ->whereHas('evaluationPhase', function($query) {
                $query->where('sequence_order', 1);
            });
    }

    public function oralEvaluations()
    {
        return $this->hasMany(Evaluation::class)
            ->whereHas('evaluationPhase', function($query) {
                $query->where('sequence_order', 2);
            });
            
    }
    
    public function calculateFinalScore()
    {
        $writtenPhaseId = EvaluationPhase::where('sequence_order', 1)->first()->id;
        $oralPhaseId = EvaluationPhase::where('sequence_order', 2)->first()->id;
        
        $writtenEvalScore = $this->evaluations()
            ->where('evaluation_phase_id', $writtenPhaseId)
            ->where('is_completed', true)
            ->avg('total_score') ?? 0;
            
        $oralEvalScore = $this->evaluations()
            ->where('evaluation_phase_id', $oralPhaseId)
            ->where('is_completed', true)
            ->avg('total_score') ?? 0;
        
        $writtenWeight = EvaluationPhase::find($writtenPhaseId)->weight / 100;
        $oralWeight = EvaluationPhase::find($oralPhaseId)->weight / 100;
        
        $finalScore = ($writtenEvalScore * $writtenWeight) + ($oralEvalScore * $oralWeight);
        
        $this->final_score = $finalScore;
        $this->save();
        
        return $finalScore;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the project creator user.
     *
     * @deprecated Prefer createdBy() relationship method for consistency.
     *             This attribute accessor can be removed if not used externally.
     */
    public function getCreatorAttribute()
    {
        return $this->createdBy()->first(); // Example, might need adjustment based on actual User model fields
    }
}
