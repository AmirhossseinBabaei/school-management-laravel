<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\UsersRepository;

class AllUsersHandler extends AudiencePhoneNotificationHandler
{
    protected UsersRepository $usersRepository;

    public function __construct(
        UsersRepository $usersRepository
    )
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(string $request, $id)
    {
        if ($request === 'allUsers') {
            return $this->usersRepository->getAllUsersPhoneNumber();
        }

        return parent::handle($request, $id);
    }
}
