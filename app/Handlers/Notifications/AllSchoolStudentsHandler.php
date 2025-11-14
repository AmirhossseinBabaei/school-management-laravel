<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\StudentsRepository;
use Illuminate\Support\Facades\Auth;

class AllSchoolStudentsHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'allSchoolStudents') {
            $schoolId = $id ?? Auth::user()->school_id;
            
            if (null == $schoolId) {
                return [];
            }

            $students = $this->studentsRepository->getStudentsBySchool($schoolId);

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

