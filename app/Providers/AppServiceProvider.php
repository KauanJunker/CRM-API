<?php

namespace App\Providers;

use App\Events\LeadCreated;
use App\Events\LeadStatusChanged;
use App\Listeners\HandleLeadStatusChangedListener;
use App\Listeners\SendLeadCreatedListener;
use App\Models\Role;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(
            LeadCreated::class,
            SendLeadCreatedListener::class,
        );
        Event::listen(
            LeadStatusChanged::class,
            HandleLeadStatusChangedListener::class,
        );
    }
}
