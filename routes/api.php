<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/webhook', [WebhookController::class, 'handleWebhook']);
Route::post('/test-openai', [WebhookController::class, 'testOpenAI']);
