<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use App\Services\WhatsApp\WhatsAppProviderInterface;

class StateManagerService
{

    private SettingRepository $settingRepository;
    private WhatsAppProviderInterface $whatsAppProvider;

    public function __construct(
        SettingRepository $settingRepository,
        WhatsAppProviderInterface $whatsAppProvider
    )
    {
        $this->settingRepository = $settingRepository;
        $this->whatsAppProvider = $whatsAppProvider;
    }

    public function toggleStateIfRequested(string|array $context, string $from): bool
    {
        if (is_array($context)) {
            return false;
        }

        if ($context == "ALTERAR ESTADO"){
            $state = $this->settingRepository->get("is_active");
            $this->settingRepository->set("is_active", !$state);

            $newState = $state ? "Desativado" : "Ativado";

            $this->whatsAppProvider->sendMessage($from, "Estado atual do OpenIA: " . $newState);
            return true;
        }
        return false;
    }

    public function isActive(): bool
    {
        if ($this->settingRepository->get("is_active")){
            return true;
        }
        return false;
    }
}
