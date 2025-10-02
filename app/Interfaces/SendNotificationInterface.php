<?php

namespace App\Interfaces;

interface SendNotificationInterface
{
    public function sendMessage(string $message, string $recipient);
}
