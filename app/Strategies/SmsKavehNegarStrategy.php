<?php

namespace App\Strategies;

use App\Interfaces\SendNotificationInterface;
use App\Repositories\NotificationsFailedRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;

class SmsKavehNegarStrategy implements SendNotificationInterface, ShouldQueue
{
    protected Client $client;
    protected string $apiKey;
    protected NotificationsFailedRepository $notificationsFailedRepository;

    public function __construct()
    {
        $this->apiKey = env('KAVENEGAR_API_KEY');

        $this->client = new Client([
            'base_uri' => "https://api.kavenegar.com/v1/{$this->apiKey}/"
        ]);

        $this->notificationsFailedRepository = new NotificationsFailedRepository();
    }

    public function sendMessage(string $message, string $recipient)
    {
        try {
            $data = $this->client->request('GET', 'verify/lookup.json', [
                'query' => [
                    'receptor' => $recipient,
                    'token' => $message,
                    'template' => 'notificationTemplate',
                ]
            ]);

            return ['data' => $data, 'status' => 200];
        } catch (GuzzleException $e) {

            $data = [
                'message' => $message,
                'phone' => $recipient,
                'exception_message' => $e->getMessage(),
                'status' => 'exception'
            ];

            $this->notificationsFailedRepository->store($data);

            return ['data' => $e->getMessage(), 'status' => 500];
        }
    }
}
