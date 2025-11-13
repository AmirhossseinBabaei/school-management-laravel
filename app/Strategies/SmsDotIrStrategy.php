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

        $this->client = new Client([
            'base_uri' => "https://api.sms.ir/v1/",
        ]);

        $this->notificationsFailedRepository = new NotificationsFailedRepository();
    }

    public function sendMessage(string $message, string $recipient, string $param1)
    {

        $payload = [
            'mobile' => $recipient,
            'templateId' => 713537,
            'parameters' => [
                ['name' => 'CODE', 'value' => $param1],
            ],
        ];

        try {
            $response = $this->client->request('POST', 'send/verify', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'x-api-key' => $this->apiKey,
                ],
                'json' => $payload
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
