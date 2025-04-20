<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_status_id',
        'changed_by',
        'comments',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
