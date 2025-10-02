<?php

namespace App\Handlers\IndexMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\RolesRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class UsersControllerDataHandler extends ControllerDataHandler
{
    protected ControllerDataHandler $next;

    protected UsersRepository $usersRepository;
    protected JalaliDateServiceStatic $jalaliDateService;
    protected SchoolsRepository $schoolsRepository;
    protected RolesRepository $rolesRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
        $this->jalaliDateService = new JalaliDateServiceStatic();
        $this->rolesRepository = new RolesRepository();
        $this->schoolsRepository = new SchoolsRepository();
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;

        return $handler;
    }

    public function adminData(): array
    {
        return [
            'users' => $this->usersRepository->getAllUsersWithRoles(),
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];
    }

    public function ownerData(string $schoolId): array
    {
        return [
            'users' => $this->usersRepository->geUsersBySchoolId($schoolId),
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'usersData') {
            if (Auth::user()->hasRole('admin')) {

                return $this->adminData();
            }

            else if (Auth::user()->hasRole('owner')) {
                $schoolId = Auth::user()->school_id;

                return $this->ownerData($schoolId);
            }
            else {
                return $this->adminData();
            }
        }

         return $this->next->handle($request);;
    }
}
