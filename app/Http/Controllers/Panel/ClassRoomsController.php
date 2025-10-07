<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateClassRoomRequest;
use App\Repositories\ClassRoomRepository;
use App\Services\JalaliDateService;
use Illuminate\View\View;

class ClassRoomsController extends Controller
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

    public function create()
    {
        $chain = app('chain.createMethodControllersData');
        $data = $chain->handle('classRoomsData');


        return view('dashboard.classRooms.create', compact('data'));
    }

    public function store(CreateClassRoomRequest $request)
    {
        $requested = $request->validated();

        $classRoom = $this->classRoomRepository->store($requested);

        if (false == $classRoom) {
            return redirect()->route('dashboard.classRooms.index')
                ->with('error', __('messages.classRooms.createClassRoomsError'));
        }

        return redirect()->route('dashboard.classRooms.index')
            ->with('success', __('messages.classRooms.createClassRoomsSuccess'));
    }

    public function show($id)
    {
        $classRoom = $this->classRoomRepository->getOneById($id);

        $this->authorize('view', $classRoom);

        if (null === $classRoom) {
            return redirect()->route('dashboard.classRooms.index')
                ->with('error', __('messages.classRooms.findClassRoomsError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'classRoom' => $classRoom
        ];

        return view('dashboard.classRooms.show', compact('data'));
    }

    public function edit(string $id)
    {
        $classRoom = $this->classRoomRepository->getOneById($id);

        $this->authorize('view', $classRoom);

        if (null === $classRoom) {
            return redirect()->route('dashboard.classRooms.index')
                ->with('error', __('messages.classRooms.findClassRoomsError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'classRoom' => $classRoom
        ];

        $chain = app('chain.createMethodControllersData');
        $data2 = $chain->handle('classRoomsData');

        return view('dashboard.classRooms.edit', compact('data', 'data2'));
    }

    public function update(CreateClassRoomRequest $request, string $id)
    {
        $requested = $request->validated();

        $classRoom = $this->classRoomRepository->getOneById($id);

        $this->authorize('update', $classRoom);

        if (null === $classRoom) {
            return redirect()->route('dashboard.classRooms.index')
                ->with('success', __('messages.classRooms.findClassRoomsError'));
        }

        $ClassRoomUpdate = $this->classRoomRepository->update($id, $requested);

        if (false == $ClassRoomUpdate) {
            return redirect()->route('dashboard.classRooms.index')
                ->with('error', __('messages.classRooms.updateClassRoomsError'));
        }
        return redirect()->route('dashboard.classRooms.index')
            ->with('success', __('messages.classRooms.updateClassRoomsSuccess'));
    }

    public function destroy(string $id)
    {
        $classRoom = $this->classRoomRepository->getOneById($id);

        $this->authorize('delete', $classRoom);

        if (null === $classRoom) {
            return redirect()->route('dashboard.classRooms.index')
                ->with('error', __('messages.classRooms.findClassRoomsError'));
        }

        $classRoomDelete = $this->classRoomRepository->destroy($id);

        if (false == $classRoomDelete){
            return response()->json(['status' => 0, __('messages.classRooms.deleteClassRoomsError')]);
        }

        return response()->json(['status' => 1, __('messages.classRooms.deleteClassRoomsSuccess')]);
    }
}
