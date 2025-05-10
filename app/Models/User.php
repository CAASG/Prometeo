<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'university',
        'university_position',
        'contact_phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Propiedad para cachear los nombres de los roles una vez cargados
    protected $roleNamesCache = null;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    // Nuevo método para obtener los nombres de los roles cacheados
    protected function getRoleNames()
    {
        if ($this->roleNamesCache === null) {
            // Carga la relación 'roles' si aún no está cargada
            // y luego obtén solo los nombres y guárdalos en caché.
            // Eager load 'roles' si no está ya cargada.
            if (!$this->relationLoaded('roles')) {
                $this->load('roles');
            }
            $this->roleNamesCache = $this->roles->pluck('name')->all();
        }
        return $this->roleNamesCache;
    }

    public function hasRole($role)
    {
        // Si $role es un array, verifica si alguno de los roles existe
        if (is_array($role)) {
            foreach ($role as $r) {
                if (in_array($r, $this->getRoleNames())) {
                    return true;
                }
            }
            return false;
        }
        // Si $role es un string, verifica si ese rol existe
        return in_array($role, $this->getRoleNames());
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isEvaluator()
    {
        return $this->hasRole('evaluator');
    }

    public function isParticipant()
    {
        return $this->hasRole('participant');
    }

    public function participatingProjects()
    {
        return $this->belongsToMany(Project::class, 'project_participants')
            ->withPivot('is_director')
            ->withTimestamps();
    }

    public function directedProjects()
    {
        return $this->belongsToMany(Project::class, 'project_participants')
            ->wherePivot('is_director', true)
            ->withTimestamps();
    }

    public function evaluatingProjects()
    {
        return $this->belongsToMany(Project::class, 'project_evaluators', 'evaluator_id')
            ->withPivot('assigned_by', 'assigned_date')
            ->withTimestamps();
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }

    public function assignedEvaluations()
    {
        return $this->hasMany(ProjectEvaluator::class, 'assigned_by');
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(ProjectDocument::class, 'uploaded_by');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function statusChanges()
    {
        return $this->hasMany(ProjectStatusHistory::class, 'changed_by');
    }

    // Importante: Si modificas los roles del usuario dinámicamente durante una petición,
    // necesitarás una forma de invalidar o resetear $roleNamesCache.
    // Por ejemplo, podrías tener un método:
    public function resetRoleCache()
    {
        $this->roleNamesCache = null;
        // También es buena idea descargar la relación para que se vuelva a cargar
        $this->unsetRelation('roles');
    }
}
