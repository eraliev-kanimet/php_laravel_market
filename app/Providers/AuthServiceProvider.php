<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\AdminPanelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $policies = [
        User::class => AdminPanelPolicy::class
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
