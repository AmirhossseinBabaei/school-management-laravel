<?php

namespace App\Handlers\Notifications;

use App\Abstracts\AudiencePhoneNotificationHandler;
use App\Repositories\StudentsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtStudentsHandler extends AudiencePhoneNotificationHandler
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
        if ($request === 'debtStudents') {
            $schoolId = Auth::user()->school_id ?? null;

            if (null == $schoolId) {
                return [];
            }

            // Check if financial table exists
            // For now, we'll return empty array if no financial system exists
            // You can implement this based on your financial system structure
            try {
                // Example: if you have a financial_transactions or student_finances table
                // $debtStudents = DB::table('student_finances')
                //     ->where('school_id', $schoolId)
                //     ->where('balance', '<', 0)
                //     ->pluck('student_id')
                //     ->toArray();
                
                // For now, return empty as financial system might not be implemented
                return [];
            } catch (\Exception $e) {
                return [];
            }
        }

        return parent::handle($request, $id);
    }
}

