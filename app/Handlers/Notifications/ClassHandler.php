<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\StudentsRepository;

class ClassHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'class') {
            if (null == $id) {
                return [];
            }

            $students = $this->studentsRepository->setModel()::where('class_id', $id)
                ->with('user')
                ->get();

            $phones = [];
            foreach ($students as $student) {
                if ($student->user && $student->user->phone) {
                    $phones[] = $student->user->phone;
                }
            }

            return array_unique($phones);
        }

        return parent::handle($request, $id);
    }
}

