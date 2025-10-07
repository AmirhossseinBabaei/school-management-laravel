<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateScheduleTeacherRequest;
use App\Models\ScheduleTeacher;
use App\Repositories\ScheduleTeachersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleTeachersController extends Controller
{

    protected ScheduleTeachersRepository $scheduleTeachersRepository;

    public function __construct(
        ScheduleTeachersRepository $scheduleTeachersRepository
    )
    {
        $this->scheduleTeachersRepository = $scheduleTeachersRepository;
    }

    public function index()
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('scheduleTeachersData');

        return view('dashboard.scheduleTeachers.all', compact('data'));
    }

    public function store(CreateScheduleTeacherRequest $request)
    {
        $requested = $request->input('schedules', []);

        $scheduleTeachersCreatedStatus = [];

        foreach ($requested as $item) {
            try {
                $schedule = ScheduleTeacher::create(
                    [
                        'teacher_id' => $item['teacher_id'],
                        'lesson_id' => $item['lesson_id'],
                        'class_id' => $item['class_id'],
                        'day_week' => $item['date_week'],
                        'start_time' => $item['start_time'],
                        'finish_time' => $item['finish_time'],
                        'school_id' => Auth::user()->school_id
                    ],
                );
                $scheduleTeachersCreatedStatus[] = $schedule;
            } catch (\Exception $e) {
                return response()->json(['status' => 0, 'message' => $e->getMessage()]);
            }
        }

        if (count($scheduleTeachersCreatedStatus) > 0) {
            return response()->json(['status' => 1, 'message' => 'hello']);
        }

        return response()->json(['status' => 0, 'message' => 'Error']);
    }
}
