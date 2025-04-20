<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_themes_map', 'project_theme_id', 'project_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
