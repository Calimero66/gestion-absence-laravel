<?php

namespace App\Providers;

use App\Models\Absence;
use App\Policies\AbsencePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        Absence::class => AbsencePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
