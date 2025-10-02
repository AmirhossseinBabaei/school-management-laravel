<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\UsersRepository;

class AllOwnersHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'allOwners') {
            return $this->usersRepository->getOwnerPhoneNumber();
        }

        return parent::handle($request, $id);
    }
}
