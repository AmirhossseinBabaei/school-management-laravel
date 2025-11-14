<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Auth;

class AllTeachersHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'allTeachers') {
            $schoolId = Auth::user()->school_id ?? null;

            $teachers = $schoolId 
                ? $this->usersRepository->getTeachersBySchoolId($schoolId)
                : $this->usersRepository->getAllTeachers();

            $phones = [];
            foreach ($teachers as $teacher) {
                if ($teacher->phone) {
                    $phones[] = $teacher->phone;
                }
            }

            return array_unique($phones);
        }

        return parent::handle($request, $id);
    }
}
