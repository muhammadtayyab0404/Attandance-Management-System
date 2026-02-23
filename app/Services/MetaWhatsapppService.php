<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class MetaWhatsapppService
{

  public function metasendMessage($phone, $message)
    {
        // Make sure phone is formatted correctly

    $response = Http::withToken(env('WHATSAPP_TOKEN'))
    ->withHeaders([
        'Content-Type' => 'application/json',
    ])
    ->post("https://graph.facebook.com/" . env('WHATSAPP_VERSION') . "/" . env('WHATSAPP_PHONE_NUMBER_ID') . "/messages", [
        "messaging_product" => "whatsapp",
        "to" => $phone,  // e.g., "9230123456"
        "type" => "template",
        "template" => [
            "name" => "hello_world",   // the template you created & approved
            "language" => ["code" => "en_US"]
        ]
    ]);

// Log for debugging
        \Log::info("WhatsApp Template response: " . $response->body());
    }

}


?>