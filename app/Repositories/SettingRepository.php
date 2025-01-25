<?php

namespace App\Repositories;

use App\Models\BotSetting;

class SettingRepository
{
    // Busca um valor pela chave
    public function get(string $key, $default = null)
    {
        return BotSetting::where('key', $key)->value('value') ?? $default;
    }

    // Define um valor para a chave (atualiza ou cria)
    public function set(string $key, $value): void
    {
        BotSetting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    // Verifica se uma configuração existe
    public function exists(string $key): bool
    {
        return BotSetting::where('key', $key)->exists();
    }
}
