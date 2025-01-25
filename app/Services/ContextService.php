<?php

namespace App\Services;

use App\Models\Context;
use App\Repositories\SettingRepository;
use DateTime;
use Illuminate\Support\Facades\Log;



class ContextService
{
    private SettingRepository $settingRepository;
    private KeyWordProcessorService $keyWordProcessor;

    public function __construct(
        SettingRepository $settingRepository,
        KeyWordProcessorService $keyWordProcessor
    )
    {
        $this->settingRepository = $settingRepository;
        $this->keyWordProcessor = $keyWordProcessor;
    }

    public function getContextByKeywords(array $keywords): array
    {
        $baseContext = $this->settingRepository->get("system_context");

        Log::info('Palavras-chave identificadas: ' . implode(', ', $keywords));

        $result = Context::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhereRaw("FIND_IN_SET(?, keyword)", [$keyword]);
            }
        })
            ->get(['context', 'completion'])
            ->reduce(fn($carry, $item) => [
                'context' => [...$carry['context'], $item->context],
                'completion' => [...$carry['completion'], $item->completion],
            ], [
                'context' => [$baseContext],
                'completion' => [''],
            ]);

        $daysWeek = [
            'Sunday' => 'Domingo',
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado',
        ];

        $state = "abertos";
        $current_time = new DateTime();
        $day = $daysWeek[date('l')];
        $closed_days = explode(",", $this->settingRepository->get("closed_days"));

        if (in_array(strtolower($day), $closed_days, true)) {
            $state = "fechados";
        } else {
            $open_hour = $this->settingRepository->get("open_hour");
            $close_hour = $this->settingRepository->get("close_hour");

            // Hora atual

            $open_time = new DateTime($open_hour);
            $close_time = new DateTime($close_hour);

            // Verifica se a hora atual está fora do horário de funcionamento
            if ($current_time < $open_time || $current_time > $close_time) {
                $state = "fechados";
            }
        }


        $result['completion'][] = '. Hoje é ' . $day . ' e agora são ' . date("H:i") . " e estamos $state";

        Log::info('Contextos recuperados: ' . implode(' | ', $result['context']));
        Log::info('Complementos recuperados: ' . implode(' | ', $result['completion']));

        // Priorizar o contexto "ALTERAR ESTADO" se encontrado
        $prioritizedContext = array_filter($result['context'], fn($context) => $context === 'ALTERAR ESTADO');

        if (!empty($prioritizedContext)) {
            return [
                'context' => reset($prioritizedContext),
                'completion' => ''
            ];
        }

        return $result;
    }

    public function getKeywords(string $message, array $history): array
    {
        $fullConversation = strtolower($message . ' ' . implode(' ', array_column($history, 'content')));
        return array_unique($this->keyWordProcessor->getKeyWords($fullConversation));
    }
}
