<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::define('delete-user', function (User $authenticatedUser, User $user) {
            // $admin = auth()->user();
            if ($authenticatedUser->role === 'admin' && $authenticatedUser->id !== $user->id) {
                return true;
            } 
        });

        Gate::define('create-admin', function (User $authenticatedUser, User $user) {
            if ($authenticatedUser->role === 'admin' && $authenticatedUser->id !== $user->id) {
                return true;
            } 
        });
    }
}
