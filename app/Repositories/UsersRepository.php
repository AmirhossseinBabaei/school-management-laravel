<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class UsersRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('users');
    }

    protected function setModel()
    {
        return User::class;
    }

    public function getAllUsersWithRoles()
    {
        return $this->setModel()::with('role')->orderBy('id', 'desc')->paginate(10);
    }

    public function getOwnersCount(): int
    {
        return $this->connection()->where('role_id', 2)->pluck('id')->count();
    }

    public function getOneById($id)
    {
        return $this->setModel()::with('role')->find($id);
    }

    public function getAllUsersPhoneNumber()
    {
        return $this->connection()->pluck('phone')->all();
    }

    public function getOwnerPhoneNumber()
    {
        return $this->connection()->where('role_id', '2')->pluck('phone')->get();
    }

    public function getUsersByRole($roleName)
    {
        return $this->setModel()::whereHas('role', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        })->get();
    }

    public function getCountTeachersBySchoolId($id): string
    {
        return $this->setModel()::where('school_id', $id)->where('role_id', 3)->pluck('id')->count();
    }

    public function geUsersBySchoolId($schoolId)
    {
        return $this->setModel()::where('school_id', $schoolId)->orderBy('id', 'desc')->paginate(10);
    }

    public function store(array $data)
    {
        return $this->setModel()::create($data);
    }

    public function all()
    {
        return $this->setModel()::all();
    }

    public function getUsersBySchoolId($schoolId)
    {
        return $this->setModel()::where('school_id', $schoolId)->get();
    }

    public function getAllTeachers()
    {
        return $this->setModel()::where('role_id', 3)->get();
    }

    public function getTeachersBySchoolId($schoolId)
    {
        return $this->setModel()::where('school_id', $schoolId)->where('role_id', 3)->get();
    }

    public function insert($data): bool
    {
        return $this->connection()->insert($data);
    }
}
