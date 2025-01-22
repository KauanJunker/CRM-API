<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLeadStatusListener
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
    public function handle(object $event): void
    {
        $lead = $event->lead;
        $lead['status'] = ($this->determineNewStatus($lead, $event->interactionType));
        $lead->save();
    }

    public function determineNewStatus($lead, $interactionType) 
    {
        if($interactionType == 'task_completed') {
            ds('chegou aqui');
            return 'em negociação';
        }
        return $lead['status'];
    }
}
