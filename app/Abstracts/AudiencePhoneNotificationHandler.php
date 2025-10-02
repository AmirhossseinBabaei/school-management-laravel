<?php

namespace App\Abstracts;

abstract class AudiencePhoneNotificationHandler
{
    protected ?AudiencePhoneNotificationHandler $next = null;

    public function setNext(AudiencePhoneNotificationHandler $handler): AudiencePhoneNotificationHandler
    {
        $this->next = $handler;
        return $handler;
    }

    public function handle(string $request, $id)
    {
        if ($this->next) {
            return $this->next->handle($request, $id);
        }

        return null;
    }
}
