<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Role; // Added import for Role model
use App\Policies\RolePolicy; // Added import for RolePolicy
use App\Models\User; // Added import for User model
use App\Policies\UserPolicy; // Added import for UserPolicy
use App\Models\ProjectCategory; // Added import for ProjectCategory model
use App\Policies\ProjectCategoryPolicy; // Added import for ProjectCategoryPolicy

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class, // Registered RolePolicy
        User::class => UserPolicy::class, // Registered UserPolicy
        ProjectCategory::class => ProjectCategoryPolicy::class, // Registered ProjectCategoryPolicy
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
} 