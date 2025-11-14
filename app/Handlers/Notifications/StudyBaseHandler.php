<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\StudentsRepository;
use Illuminate\Support\Facades\Auth;

class StudyBaseHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'studyBase') {
            if (null == $id) {
                return [];
            }

            $schoolId = Auth::user()->school_id ?? null;

            $query = $this->studentsRepository->setModel()::where('study_base_id', $id)
                ->with('user');

            if ($schoolId) {
                $query->where('school_id', $schoolId);
            }

            $students = $query->get();

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
