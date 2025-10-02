<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\AttendancesRepository;

class AllAttendanceSchoolHandler extends AudiencePhoneNotificationHandler
{
    protected AttendancesRepository $attendancesRepository;

    public function __construct(
        AttendancesRepository $attendancesRepository
    )
    {
        $this->attendancesRepository = $attendancesRepository;
    }

    public function handle(string $request, $id)
    {
        if ($request === 'attendanceSchool') {
            return $this->attendancesRepository->getPhoneStudentsAttendance();
        }

        return parent::handle($request, $id);
    }
}
