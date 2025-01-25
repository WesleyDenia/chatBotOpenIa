<?php

namespace App\Services\WhatsApp\Providers;

use App\Services\WhatsApp\WhatsAppProviderInterface;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

use Exception;

class TwilioProvider implements WhatsAppProviderInterface
{
    protected Client $twilio;
    protected string $from;

    /**
     * @throws ConfigurationException
     * @throws Exception
     */
    public function __construct()
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');
        $this->from = config('services.twilio.whatsapp_from');

        if (empty($accountSid) || empty($authToken)) {
            throw new Exception('As credenciais do Twilio não estão configuradas.');
        }

        $this->twilio = new Client($accountSid, $authToken);
    }

    /**
     * @throws TwilioException
     */
    public function sendMessage(string $to, string $body): array
    {
        $to = str_starts_with($to, 'whatsapp:') ? $to : "whatsapp:$to";

        $message = $this->twilio->messages->create(
            $to,
            [
                'from' => $this->from,
                'body' => $body,
            ]
        );

        return ['status' => $message->status];
    }
}
