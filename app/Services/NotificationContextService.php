<?php

namespace App\Services;

use App\Interfaces\SendNotificationInterface;

class NotificationContextService
{
    protected SendNotificationInterface $sendNotification;

    public function __construct(
        SendNotificationInterface $sendNotification
    )
    {
        $this->sendNotification = $sendNotification;
    }

    public function setStrategy(SendNotificationInterface $sendNotification)
    {
        $this->sendNotification = $sendNotification;
    }

    public function sendNotification($message, array $recipients, string $param1): array
    {
        $results = [];

        foreach ($recipients as $recipient) {
            $result = $this->sendNotification->sendMessage($message, $recipient, $param1);
            $results[] = $result;
        }

        return $results;
    }
}
