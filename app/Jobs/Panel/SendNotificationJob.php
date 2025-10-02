<?php

namespace App\Jobs\Panel;

use App\Interfaces\SendNotificationInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    protected string $message;
    protected string $receptor;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $message,
        string $receptor,
    )
    {
        $this->message = $message;
        $this->receptor = $receptor;
    }

    /**
     * Execute the job.
     */
    public function handle($sendNotificationStrategy): void
    {
        $sendNotificationStrategy->sendMessage($this->message, $this->receptor);
    }
}
