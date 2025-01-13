<?php

namespace App\Listeners;

use App\Events\LeadStatusChanged;
use App\Notifications\LeadStatusChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleLeadStatusChangedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LeadStatusChanged $event): void
    {
        $user = $event->user;
        $lead = $event->lead;
        $user->notify(new LeadStatusChangedNotification($user, $lead));
    }
}
