<?php

namespace App\Services\WhatsApp\Providers;

use App\Services\WhatsApp\WhatsAppProviderInterface;
use GuzzleHttp\Client;

class UltraMsgProvider implements WhatsAppProviderInterface
{
    private $client;
    private $instance;
    private $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->instance = env('ULTRAMSG_INSTANCE');
        $this->token = env('ULTRAMSG_TOKEN');
    }

    public function sendMessage(string $to, string $body): array
    {
        $response = $this->client->post("https://api.ultramsg.com/{$this->instance}/messages/chat", [
            'form_params' => [
                'token' => $this->token,
                'to' => $to,
                'body' => $body,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
