<?php

namespace App\Services\WhatsApp;

interface WhatsAppProviderInterface
{
    public function sendMessage(string $to, string $body): array;
}
