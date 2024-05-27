<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Register the available scopes
        Passport::tokensCan([
            'place-tasks' => 'Place tasks',
            'check-tasks' => 'Check tasks',
            'update-tasks' => 'Update tasks',
            'delete-tasks' => 'Delete tasks',
            'see-users' => 'See Users',
        ]);

        Passport::setDefaultScope([
            'place-tasks',
            'check-tasks',
            'update-tasks'
        ]);
        // Passport::loadKeysFrom(__DIR__ . '/../secrets/oauth');
        // Passport::tokensExpireIn(now()->addDays(15));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
