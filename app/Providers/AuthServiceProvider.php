<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Policies\InvoicePolicy;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Invoice::class => InvoicePolicy::class,
        Order::class => OrderPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define("isManager", function(User $user){
            return $user && $user->role->canonical_name !== "sales";
        });
    }
}
