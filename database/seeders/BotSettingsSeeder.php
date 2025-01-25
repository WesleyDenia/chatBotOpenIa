<?php

namespace Database\Seeders;

use App\Models\BotSetting;
use Illuminate\Database\Seeder;

class BotSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'is_active', 'value' => true],
            ['key' => 'stop_words', 'value' => 'o,a,os,as,de,do,da,em,é,e,um,uma,por,para,com'],
            ['key' => 'history_limit', 'value' => 3],
            ['key' => 'open_hour', 'value' => "12:00"],
            ['key' => 'close_hour', 'value' => "21:00"],
            ['key' => 'closed_days', 'value' => "domingo,terça-feira"],
            ['key' => 'system_context', 'value' => 'Você é um assistente virtual da loja Salgados do Marquês. Sua função é responder os clientes de maneira simpática, profissional e clara. Utilize formatação como *negrito* e emojis para tornar as mensagens mais amigáveis, mas sem exagerar.\n\n'],
            ['key' => 'prompt_completion', 'value' => '. Por favor, *nunca se desculpe* por suas respostas, a menos que o usuário sinalize um erro. Responda diretamente em formato de mensagens do WhatsApp, utilizando *negrito* para destacar informações importantes, quebras de linha para facilitar a leitura, e emojis para deixar a conversa simpática. Certifique-se de que as respostas sejam claras e bem formatadas.\n\n Fale a respeito do horário apenas se o cliente perguntar'],
        ];

        foreach ($settings as $setting) {
            BotSetting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
