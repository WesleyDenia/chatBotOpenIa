<?php

namespace App\Services;

use App\Repositories\MessageRepository;

class MessageProcessorService
{
    protected MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function processIncomingMessage(array $data, string $response): void
    {
        if ($this->messageRepository->findByWhatsAppId($data['MessageSid'])) {
            return;
        }

        $processedData = [
            'whatsapp_id' => $data['MessageSid'],
            'from' => str_replace('whatsapp:', '', $data['From']),
            'to' => str_replace('whatsapp:', '', $data['To']),
            'content' => $this->sanitizeText($data['Body']),
            'response' => $this->sanitizeText($response),
            'profile_name' => $data['ProfileName'],
            'message_type' => $data['MessageType'],
        ];

        $this->messageRepository->save($processedData);
    }

    function sanitizeText(string $text): string
    {
        // Remover emojis (baseado em intervalos Unicode)
        $text = preg_replace('/[\x{1F600}-\x{1F64F}' .
            '\x{1F300}-\x{1F5FF}' .
            '\x{1F680}-\x{1F6FF}' .
            '\x{1F700}-\x{1F77F}' .
            '\x{1F780}-\x{1F7FF}' .
            '\x{1F800}-\x{1F8FF}' .
            '\x{1F900}-\x{1F9FF}' .
            '\x{2600}-\x{26FF}' .
            '\x{2700}-\x{27BF}' .
            '\x{FE00}-\x{FE0F}' .
            '\x{1FA70}-\x{1FAFF}' .
            '\x{1F1E6}-\x{1F1FF}' .
            ']+/u', '', $text);

        // Substituir múltiplos espaços por um único espaço
        $text = preg_replace('/\s+/', ' ', $text);

        // Remover espaços extras no início e no fim
        return trim($text);
    }

    public function hasOrderFinalizedStatus(string $message): bool
    {
        return str_contains($message, 'STATUS: ENCOMENDA_FINALIZADA');
    }
}

