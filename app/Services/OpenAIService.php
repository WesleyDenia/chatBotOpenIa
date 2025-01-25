<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use OpenAI\Factory as OpenAIFactory;
use OpenAI\Client as OpenAIClient;
use Exception;

class OpenAIService
{
    protected OpenAIClient $openAIClient;
    private MessageProcessorService $processor;

    /**
     * @throws Exception
     */
    public function __construct(MessageProcessorService $processor)
    {
        $apiKey = config('services.openai.api_key');

        if (empty($apiKey)) throw new Exception('A API Key da OpenAI não está configurada.');

        $this->openAIClient = (new OpenAIFactory())
            ->withApiKey($apiKey)
            ->make();
        $this->processor = $processor;
    }

    public function generateResponse(array $messages): string
    {
        Log::info('Json Send for API OpenIA: ' . json_encode($messages));

        $result = $this->openAIClient->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]);

        Log::info('Response to OpenIA: ' . json_encode($result));

        return trim($result['choices'][0]['message']['content']);
    }

    public function generateResponseTest(array $messages): array
    {
        Log::info('JSON de teste enviado para API OpenAI: ' . json_encode($messages));

        $result = $this->openAIClient->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]);

        $responseContent = trim($result['choices'][0]['message']['content']);

        Log::info('Resposta de teste da OpenAI: ' . json_encode($result));

        $orderFinalizedStatus = $this->processor->hasOrderFinalizedStatus($responseContent);
        Log::info('Resposta de teste da OpenAI: ' . json_encode($result));

        $number_order = ($orderFinalizedStatus) ? "Encomenda Número: 123456" : "";

        $response["messages"] = $messages;
        $response["messages"][] = [
            'role' => 'assistant',
            'content' => $responseContent.'\n\n'.$number_order,
        ];
        $response["messages"][] = [
            'role' => 'user',
            'content' => ''
        ];
        $response["openai_response"] = $responseContent;

        return $response;
    }
}

