<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateUserRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Repositories\RolesRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\UsersRepository;
use App\Services\ExcelReader;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Shuchkin\SimpleXLSX;

class UsersController extends Controller
{
    protected UsersRepository $usersRepository;
    protected JalaliDateServiceStatic $jalaliDateService;
    protected SchoolsRepository $schoolsRepository;
    protected RolesRepository $rolesRepository;

    public function __construct(
        UsersRepository         $usersRepository,
        JalaliDateServiceStatic $jalaliDateService,
        SchoolsRepository       $schoolsRepository,
        RolesRepository         $rolesRepository,
    )
    {
        $this->usersRepository = $usersRepository;
        $this->jalaliDateService = $jalaliDateService;
        $this->rolesRepository = $rolesRepository;
        $this->schoolsRepository = $schoolsRepository;
    }

    public function index(): View
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('usersData');

        return view('dashboard.users.all', compact('data'));
    }

    public function show($id): View
    {
        $user = $this->usersRepository->getOneById($id);

        $this->authorize('view', $user);

        if (null === $user) {
            return redirect()->route('dashboard.users.index')->with('error', __('messages.users.findUserError'));
        }

        $data = [
            'user' => $user,
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.users.show', compact('data'));
    }

    public function create(): View
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'roles' => $this->rolesRepository->getAllByPaginate(),
            'schools' => $this->schoolsRepository->all()
        ];

        if (!Auth::user()->hasRole('admin')) {
            unset($data['roles'][4]);
        }

        return view('dashboard.users.create', compact('data'));
    }

    public function store(CreateUserRequest $request)
    {
        $requested = $request->validated();

        $request['password_hash'] = Hash::make($request['password_hash']);

        if (!Auth::user()->hasRole('admin')) {
            $requested['school_id'] = Auth::user()->school_id;

            if ($requested['role_id'] == 1) {
                return Auth::logout();
            }
        }

        $user = $this->usersRepository->store($requested);

        if (false === $user) {
            return redirect()->route('dashboard.users.index')->with('error', __('messages.users.createUserError'));
        }

        return redirect()->route('dashboard.users.index')->with('success', __('messages.users.createUserSuccess'));
    }

    public function edit($id): View
    {
        $user = $this->usersRepository->getOneById($id);

        $this->authorize('view', $user);

        if (null === $user) {
            return redirect()->route('dashboard.users.index')->with('error', __('messages.users.findUserError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'roles' => $this->rolesRepository->all(),
            'schools' => $this->schoolsRepository->all(),
            'user' => $user
        ];

        return view('dashboard.users.edit', compact('data'));
    }

    public function update($id, UpdateUserRequest $request)
    {
        $requested = $request->validated();

        $user = $this->usersRepository->getOneById($id);

        $this->authorize('update', $user);

        if (null === $user) {
            return redirect()->route('dashboard.users.index')->with('error', __('messages.users.findUserError'));
        }

        $updateUser = $this->usersRepository->update($id, $requested);

        if (false == $updateUser) {
            return redirect()->route('dashboard.users.index')->with('error', __('messages.users.updateUserError'));
        }

        return redirect()->route('dashboard.users.index')->with('success', __('messages.users.updateUserSuccess'));
    }

    public function destroy($id)
    {
        $user = $this->usersRepository->getOneById($id);

        $this->authorize('delete', $user);

        if (null === $user) {
            return redirect()->route('dashboard.users.index')->with('error', __('messages.users.findUserError'));
        }

        $userDeleted = $this->usersRepository->destroy($id);

        if (true == $userDeleted) {
            return response()->json(['status' => 1, 'message' => __('messages.users.deleteUserSuccess')]);
        }

        return response()->json(['status' => 0, 'message' => __('messages.users.deleteUserError')]);
    }

    public function createByExcel(Request $request)
    {
        $request->validate([
            'users' => 'required|file|mimes:xlsx,xls',
        ]);

        $filePath = $request->file('users')->getRealPath();

        if ($xlsx = SimpleXLSX::parse($filePath)) {
            $rows = $xlsx->rows();

            $data = array_slice($rows, 1);

            $this->usersRepository->insert($data);

        } else {
            return response()->json([
                'error' => SimpleXLSX::parseError(),
            ], 400);
        }
    }
}
