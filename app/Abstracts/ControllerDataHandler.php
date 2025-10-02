<?php

namespace App\Abstracts;

abstract class ControllerDataHandler
{
    protected ControllerDataHandler $next;

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;
        return $handler;
    }

    public function handle(string $request)
    {
        if ($request) {
            return $this->next->handle($request);
        }

        return null;
    }
}
