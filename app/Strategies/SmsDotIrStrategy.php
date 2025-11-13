<?php

namespace App\Strategies;

use App\Interfaces\SendNotificationInterface;
use App\Repositories\NotificationsFailedRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;

class SmsDotIrStrategy implements SendNotificationInterface, ShouldQueue
{
    protected Client $client;
    protected string $apiKey;
    protected NotificationsFailedRepository $notificationsFailedRepository;

    public function __construct()
    {
        $this->apiKey = '70a92m4ogdnN3YQzgRc3fYvq6FcqKrCaeEWjflE4DfgqTFlM';
//        $this->secretKey = env('SMS_IR_SECRET_KEY');

        $this->client = new Client([
            'base_uri' => "https://api.sms.ir/v1/",
            'timeout' => 5.0,
        ]);

        $this->notificationsFailedRepository = new NotificationsFailedRepository();
    }

    public function sendMessage(string $message, string $recipient)
    {
        $lineNumber = '30002101005257';

        $payload = [
            'Mobile' => [$recipient],
            'Messages' => [$message],
            'Templated' => $lineNumber,
            'Parameters' => ['name' => 'code', 'value' => '123456'],
            'CanContinueInCaseOfError' => 'false'
        ];

        try {
            $response = $this->client->request('POST', 'send/verify', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-KEY' => $this->apiKey,
//                    'X-SECRET-KEY' => $this->secretKey,
                ],
                'body' => json_encode($payload)
            ]);

            return ['data' => $response->getBody()->getContents(), 'status' => $response->getStatusCode()];

        } catch (GuzzleException $e) {
            $this->notificationsFailedRepository->create([
                'message' => $message,
                'recipient' => $recipient,
                'error' => $e->getMessage()
            ]);

            return ['data' => $e->getMessage(), 'status' => 500];
        }
    }
}
