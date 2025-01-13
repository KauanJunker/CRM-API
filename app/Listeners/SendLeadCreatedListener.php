<?php

namespace App\Listeners;

use App\Events\LeadCreated;
use App\Mail\WelcomeEmail;
use App\Notifications\LeadCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendLeadCreatedListener
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
    public function handle(LeadCreated $event): void
    {
        $lead = $event->lead;
        $lead->notify(new LeadCreatedNotification($lead));
    }
}
