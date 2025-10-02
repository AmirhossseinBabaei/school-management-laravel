<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use App\Services\UsersService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected UsersRepository $usersRepository;
    protected StudentsRepository $studentsRepository;
    protected SchoolsRepository $schoolsRepository;
    protected JalaliDateServiceStatic $jalaliDateService;
    protected UsersService $userService;

    public function __construct(
        UsersRepository         $usersRepository,
        StudentsRepository      $studentsRepository,
        SchoolsRepository       $schoolsRepository,
        JalaliDateServiceStatic $jalaliDateService,
        UsersService            $userService
    )
    {
        $this->usersRepository = $usersRepository;
        $this->studentsRepository = $studentsRepository;
        $this->schoolsRepository = $schoolsRepository;
        $this->jalaliDateService = $jalaliDateService;
        $this->userService = $userService;
    }

    public function index(): View
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('dashboardData');

        return view('dashboard.index', compact("data"));
    }
}
