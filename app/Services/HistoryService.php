<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\SettingRepository;

class HistoryService
{

    private SettingRepository $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getHistoryChat(string $from): array
    {
        $historyLimit = $this->settingRepository->get("history_limit") ?? 3;
        $from = str_replace('whatsapp:', '', $from);

        $history = Message::where('from', $from)
            ->orderBy('created_at', 'asc')
            ->take($historyLimit)
            ->get(['content', 'response', 'created_at'])
            ->toArray();

        return array_unique($history, SORT_REGULAR);
    }
}

