<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\ClassRoomRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassRoomController extends Controller
{
    protected ClassRoomRepository $classRoomRepository;
    protected JalaliDateService $jalaliDateService;

    public function __construct(
        ClassRoomRepository $classRoomRepository,
        JalaliDateService $jalaliDateService
    )
    {
        $this->classRoomRepository = $classRoomRepository;
        $this->jalaliDateService = $jalaliDateService;
    }

    public function index(): View
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('classRoomsData');

        return view('dashboard.classRooms.all', compact('data'));
    }
}
