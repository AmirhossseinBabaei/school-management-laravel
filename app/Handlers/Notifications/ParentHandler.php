<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\StudentsRepository;

class ParentHandler extends AudiencePhoneNotificationHandler
{
    protected StudentsRepository $studentsRepository;

    public function __construct(
        StudentsRepository $studentsRepository
    )
    {
        $this->studentsRepository = $studentsRepository;
    }

    public function handle(string $request, $id)
    {
        if ($request === 'parent') {
            if (null == $id) {
                return [];
            }

            $student = $this->studentsRepository->getOneById($id);

            if ($student && $student->user && $student->user->phone) {
                return [$student->user->phone];
            }

            return [];
        }

        return parent::handle($request, $id);
    }
}

