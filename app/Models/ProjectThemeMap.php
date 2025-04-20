<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectThemeMap extends Model
{
    use HasFactory;

    protected $table = 'project_themes_map';

    protected $fillable = [
        'project_id',
        'project_theme_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function theme()
    {
        return $this->belongsTo(ProjectTheme::class, 'project_theme_id');
    }
}
