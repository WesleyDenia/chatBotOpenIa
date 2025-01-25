<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Log;

class MessageAssemblerService
{

    private SettingRepository $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function assembleMessages(string $message, array $context, array $history): array
    {
        $combinedContextContent = implode("\n\n", $context['context']);
        $combinedCompletionContent = implode("\n\n", $context['completion']);

        $messages = [
            ['role' => 'system', 'content' => $combinedContextContent]
        ];

        foreach ($history as $chat) {
            $messages[] = ['role' => 'user', 'content' => $chat['content']];
            if (!empty($chat['response'])) {
                $messages[] = ['role' => 'assistant', 'content' => $chat['response']];
            }
        }

        $messages[] = [
            'role' => 'user',
            'content' => $message .
                $this->settingRepository->get("prompt_completion") . $combinedCompletionContent
        ];

        return $messages;
    }
}
