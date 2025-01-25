<?php

namespace App\Services;

use App\Repositories\SettingRepository;

class KeyWordProcessorService
{
    protected $SettingRepository;

    public function __construct(SettingRepository $SettingRepository)
    {
        $this->SettingRepository = $SettingRepository;
    }

    public function getKeyWords(string $message): array
    {
        $stopWords = explode(',', $this->SettingRepository->get("stop_words"));
        $cleanMessage = preg_replace('/[^\w\s]/u', '', $message);
        $keywords = array_diff(explode(' ', $cleanMessage), $stopWords);

        return array_unique($keywords);
    }
}
