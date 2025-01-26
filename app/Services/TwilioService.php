<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    /**
     * Enviar mensagem SMS.
     */
    public function sendSms($to, $message)
    {
        
    }

    /**
     * Enviar mensagem via WhatsApp.
     */
    public function sendWhatsApp($to, $message)
    {
        $from = config('twilio.phone_number');
        $message = $this->client->messages->create("whatsapp:" . $to, 
        [
            'from' => "whatsapp:" . $from,
            'body' => $message,
        ]);
    }
}
