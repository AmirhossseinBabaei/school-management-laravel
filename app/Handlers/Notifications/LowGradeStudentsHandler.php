<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\GradesRepository;
use App\Repositories\StudentsRepository;
use Illuminate\Support\Facades\Auth;

class LowGradeStudentsHandler extends AudiencePhoneNotificationHandler
{
    protected GradesRepository $gradesRepository;
    protected StudentsRepository $studentsRepository;

    public function __construct(
        GradesRepository $gradesRepository,
        StudentsRepository $studentsRepository
    )
    {
        $this->gradesRepository = $gradesRepository;
        $this->studentsRepository = $studentsRepository;
    }

    public function handle(string $request, $id)
    {
        if ($request === 'lowGradeStudents') {
            $schoolId = Auth::user()->school_id ?? null;
            $minGrade = $id ?? 10; // Default minimum grade is 10

            if (null == $schoolId) {
                return [];
            }

            // Get students with average grade less than minGrade
            $lowGradeStudents = $this->gradesRepository->setModel()::select('student_id')
                ->selectRaw('AVG(score) as avg_score')
                ->whereHas('student', function ($query) use ($schoolId) {
                    $query->where('school_id', $schoolId);
                })
                ->groupBy('student_id')
                ->havingRaw('AVG(score) < ?', [$minGrade])
                ->get();

            $studentIds = $lowGradeStudents->pluck('student_id')->toArray();

            $students = $this->studentsRepository->setModel()::whereIn('id', $studentIds)
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

