<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
    public function save(array $data)
    {
        return Message::create($data);
    }

    public function findByWhatsAppId($whatsappId)
    {
        return Message::where('whatsapp_id', $whatsappId)->first();
    }
}
