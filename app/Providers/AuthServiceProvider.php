<?php

namespace App\Providers;

use Auth;
use Illuminate\Auth\Notifications\ResetPassword;
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
        'App\Models\Log' => 'App\Policies\LogPolicy',
        'App\Models\Setting' => 'App\Policies\SettingPolicy',
        'App\Models\RechargedCard' => 'App\Policies\RechargedCardPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\AccountType' => 'App\Policies\AccountTypePolicy',
        'App\Models\AccountInfo' => 'App\Policies\AccountInfoPolicy',
        'App\Models\Account' => 'App\Policies\AccountPolicy',
        'App\Models\Pivot\AccountAccountInfo' => 'App\Policies\Pivot\AccountAccountInfoPolicy',
        'App\Models\Validator' => 'App\Policies\ValidatorPolicy',
        'App\Models\Validation' => 'App\Policies\ValidationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Custom reset password url when user forgot
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return env('APP_BASE_RESET_PASSWORD_URL', env('APP_URL') . '/reset-password') . '?token=' . $token;
        });
    }
}
