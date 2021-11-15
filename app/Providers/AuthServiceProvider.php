<?php

namespace App\Providers;

use App\Models\Persona;
use App\Models\Team;
use App\Models\User;
use App\Policies\PersonaPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Persona::class => PersonaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('eliminar-persona', function(User $user, Persona $persona){
            //return false;
            return $user->id == $persona->user_id;
        });
    }
}
