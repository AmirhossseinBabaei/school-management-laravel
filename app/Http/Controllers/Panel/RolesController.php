<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateRoleRequest;
use App\Repositories\RolesRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    protected RolesRepository $rolesRepository;
    protected JalaliDateService $jalaliDateService;

    public function __construct(
        RolesRepository   $rolesRepository,
        JalaliDateService $jalaliDateService
    )
    {
        $this->rolesRepository = $rolesRepository;
        $this->jalaliDateService = $jalaliDateService;
    }

    public function index()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'roles' => $this->rolesRepository->getAllByPaginate()
        ];

        return view('dashboard.roles.all', compact('data'));
    }

    public function create()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.roles.create', compact('data'));
    }

    public function store(CreateRoleRequest $request)
    {
        $requested = $request->validated();

        $role = $this->rolesRepository->store($requested);

        if (false === $role) {
            return redirect()->route('dashboard.roles.index')->with('error', __('messages.roles.createRoleError'));
        }

        return redirect()->route('dashboard.roles.index')->with('success', __('messages.roles.createRoleSuccess'));
    }

    public function show(string $id)
    {
        $role = $this->rolesRepository->getOneById($id);

        if (null === $role) {
            return redirect()->route('dashboard.roles.index')->with('error', __('messages.roles.findRoleError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'role' => $role
        ];

        return view('dashboard.roles.show', compact('data'));
    }

    public function edit(string $id)
    {
        $role = $this->rolesRepository->getOneById($id);

        if (null === $role) {
            return redirect()->route('dashboard.roles.index')->with('error', __('messages.roles.findRoleError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'role' => $role
        ];

        return view('dashboard.roles.edit', compact('data'));
    }

    public function update(CreateRoleRequest $request, string $id)
    {
        $requested = $request->validated();

        $role = $this->rolesRepository->getOneById($id);

        if (null === $role) {
            return redirect()->route('dashboard.roles.index')->with('error', __('messages.roles.findRoleError'));
        }

        $updateRole = $this->rolesRepository->update($id, $requested);

        if (false == $updateRole) {
            return redirect()->route('dashboard.roles.index')->with('error', __('messages.roles.updateRoleError'));
        }

        return redirect()->route('dashboard.roles.index')->with('success', __('messages.roles.updateRoleSuccess'));
    }


    public function destroy($id): JsonResponse
    {
        $role = $this->rolesRepository->getOneById($id);

        if (null === $role) {
            return redirect()->route('dashboard.roles.index')->with('error', __('messages.roles.findRoleError'));
        }

        $roleDeleted = $this->rolesRepository->destroy($id);

        if (true === $roleDeleted) {
            return response()->json(['status' => 1, 'message' => __('messages.roles.deleteRoleSuccess')]);
        }

        return response()->json(['status' => 0, 'message' => __('messages.roles.deleteRoleError')]);
    }
}
