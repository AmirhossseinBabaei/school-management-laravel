<?php

namespace App\Interfaces;

interface SendNotificationInterface
{
    public function sendMessage($message, string $recipient, string $param1);
}
