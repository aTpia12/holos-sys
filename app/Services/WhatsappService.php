<?php

namespace App\Services;

use GuzzleHttp\Client;

class WhatsappService
{
    public function send($number, $user)
    {
        $client = new Client();
        $response = $client->post(env('WHATSAPP_API_URL'), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('WHATSAPP_TOKEN'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'messaging_product' => 'whatsapp',
                'to' => $number,
                'type' => 'template',
                'template' => [
                    'name' => 'register_holos',
                    'language' => [
                        'code' => 'es_MX'
                    ],
                    'components' => [
            [
                'type' => 'body',
                'parameters' => [
                    ['type' => 'text', 'text' => $user->name],
                    ['type' => 'text', 'text' => $user->phone],
                    ['type' => 'text', 'text' => $user->email],
                    // Agrega más parámetros según sea necesario
                ]
            ]
        ]
                ],
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            return true;
        } else {

            return false;
        }
    }
}
