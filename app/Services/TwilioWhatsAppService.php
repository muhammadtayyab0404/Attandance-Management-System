<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;

class TwilioWhatsAppService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );
    }

    public function sendMessage($phone, $message)
    {
        // Make sure phone is formatted correctly
        $formattedPhone = preg_replace('/[^0-9]/', '', $phone); // remove non-numeric characters

        try {
            $response = $this->twilio->messages->create(
                "whatsapp:+".$formattedPhone,
                [
                    "from" => env('TWILIO_WHATSAPP_FROM'),
                    "body" => $message
                ]
            );

            // Log the Twilio SID & status for debugging
            Log::info("WhatsApp message sent to {$formattedPhone}", [
                'sid' => $response->sid ?? null,
                'status' => $response->status ?? null,
                'to' => $response->to ?? null,
                'from' => $response->from ?? null,
            ]);

            return $response;

        } catch (TwilioException $e) {
            // Catch Twilio-specific exceptions
            Log::error("Twilio Exception for {$formattedPhone}: " . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            // Catch any other exceptions
            Log::error("General Exception for {$formattedPhone}: " . $e->getMessage());
            return null;
        }
    }
}