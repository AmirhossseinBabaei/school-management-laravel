<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\AttendancesRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsentStudentsHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'absentStudents') {
            $schoolId = Auth::user()->school_id ?? null;

            if (null == $schoolId) {
                return [];
            }

            // Get absent students today
            $absentStudents = $this->attendancesRepository->setModel()::where('school_id', $schoolId)
                ->whereDate('attended_at', Carbon::today())
                ->where('status', 'absent')
                ->with('student.user')
                ->get();

            $phones = [];
            foreach ($absentStudents as $attendance) {
                if ($attendance->student && $attendance->student->user && $attendance->student->user->phone) {
                    $phones[] = $attendance->student->user->phone;
                }
            }

            return array_unique($phones);
        }

        return parent::handle($request, $id);
    }
}