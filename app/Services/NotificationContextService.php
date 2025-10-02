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

    public function sendNotification(string $message, array $recipients): array
    {
        $results = [];

        foreach ($recipients as $recipient) {
            $result = $this->sendNotification->sendMessage($message, $recipient);
            $results[] = $result;
        }

        return $results;
    }
}
