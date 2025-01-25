<?php

namespace App\Services;

use App\Services\WhatsApp\WhatsAppProviderInterface;

class ChatBotService
{
    protected MessageProcessorService $processor;
    protected OpenAIService $openAI;
    protected ContextService $context;
    protected HistoryService $history;
    private WhatsAppProviderInterface $whatsAppProvider;
    private StateManagerService $stateManager;
    private MessageAssemblerService $messageAssembler;

    public function __construct(
        StateManagerService $stateManager,
        MessageProcessorService $processor,
        MessageAssemblerService $messageAssembler,
        OpenAIService $openAI,
        ContextService $context,
        HistoryService $history,
        WhatsAppProviderInterface $whatsAppProvider

    ) {

        $this->processor = $processor;
        $this->openAI = $openAI;
        $this->context = $context;
        $this->history = $history;
        $this->whatsAppProvider = $whatsAppProvider;
        $this->stateManager = $stateManager;
        $this->messageAssembler = $messageAssembler;
    }

    public function handleIncomingMessage(array $data): void
    {

        $message = $data['Body'];

        $history = $this->history->getHistoryChat($data['From']);

        $keywords = $this->context->getKeywords($message, $history);

        $context = $this->context->getContextByKeywords($keywords);

        if ($this->stateManager->toggleStateIfRequested($context['context'], $data['From'])) {
            return;
        }

        if (!$this->stateManager->isActive()) {
            return;
        }

        $messages = $this->messageAssembler->assembleMessages($message, $context, $history);

        $response = $this->openAI->generateResponse($messages);

        $this->processor->processIncomingMessage($data, $response);

        $this->whatsAppProvider->sendMessage($data['From'], $response);
    }

    public function handleIncomingMessageForTest(array $data): array
    {
        $message = $data['Body'];
        $history = $this->history->getHistoryChat($data['From']);
        $keywords = $this->context->getKeywords($message, $history);
        $context = $this->context->getContextByKeywords($keywords);

        if ($this->stateManager->toggleStateIfRequested($context['context'], $data['From'])) {
            return [];
        }

        if (!$this->stateManager->isActive()) {
            return [];
        }

        $messages = $this->messageAssembler->assembleMessages($message, $context, $history);

        $response = $this->openAI->generateResponseTest($messages);

        $this->processor->processIncomingMessage($data, $response['openai_response']);

        return $response["messages"];
    }

    public function generateTestResponse(array $messages): string|array
    {
        $response = $this->openAI->generateResponseTest($messages);
        return $response["messages"];
    }
}
