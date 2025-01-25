<?php

namespace App\Http\Controllers;

use App\Services\ChatBotService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class WebhookController extends Controller
{
    protected ChatBotService $chatBotService;

    public function __construct(ChatBotService $chatBotService)
    {
        $this->chatBotService = $chatBotService;
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        try {
            if (config('app.chatbot_test_mode', false)) {
                $response = $this->chatBotService->handleIncomingMessageForTest($request->all());

                Log::info('Webhook processado no modo de teste.');
                return response()->json(['messages' => $response]);
            }

            $this->chatBotService->handleIncomingMessage($request->all());

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            Log::error('Webhook processing failed: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function testOpenAI(Request $request): JsonResponse
    {
        try {
            if (!config('app.chatbot_test_mode', false)) {
                return response()->json(['error' => 'Este endpoint só está disponível no modo de teste.'], 403);
            }

            $validated = $request->validate([
                'messages' => 'required|array',
            ]);

            $messages = $validated['messages'];
            $updatedMessages = $this->chatBotService->generateTestResponse($messages);

            return response()->json(['messages' => $updatedMessages]);
        } catch (Exception $e) {
            Log::error('Erro ao processar o JSON para OpenAI: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao processar o pedido.'], 500);
        }
    }

}
