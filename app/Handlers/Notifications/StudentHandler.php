<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\StudentsRepository;

class StudentHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'student') {

            if (null == $id) {
                return [];
            }

            $student = $this->studentsRepository->getOneById($id);

            if ($student->user === null) {
                return [];
            }

            return [$this->studentsRepository->getOneById($id)->user->phone] ?? [];
        }
    }

}
