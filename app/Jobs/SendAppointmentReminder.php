<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Twilio\Rest\Client;

class SendAppointmentReminder implements ShouldQueue
{
    use Queueable;
    protected $client;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(TwilioService $twilioService): void
    {
        $upcomingAppointments = Appointment::where('appointment_date', '>=', now())
            ->where('appointment_date', '<=', now()->addDay())
            ->with('lead')
            ->get();

        foreach ($upcomingAppointments as $appointment) {
            $lead = $appointment->lead;

            if ($lead->phone) {
                $formattedDate = $appointment->appointment_date instanceof \DateTimeInterface
                ? $appointment->appointment_date->format('d/m/Y H:i')
                : Carbon::parse($appointment->appointment_date)->format('d/m/Y \à\s H:i');
                $message = "Olá, {$lead->name}! Você tem uma reunião agendada para {$formattedDate}";
                   
                $twilioService->sendWhatsApp($lead->phone, $message);
            }
        }
    }
}
