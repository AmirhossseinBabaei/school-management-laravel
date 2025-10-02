<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class StudentsRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('students');
    }

    public function setModel(): string
    {
        return Student::class;
    }

    public function all()
    {
        return $this->setModel()::all();
    }

    public function getOneById($id)
    {
        return $this->setModel()::find($id);
    }

    /**
     * Get all students with their relations
     */
    public function getAllStudentsWithRelations()
    {
        return $this->setModel()::with(['user', 'school'])
            ->orderBy('id', 'desc')
            ->paginate(15);
    }

    /**
     * Get one student by ID with relations
     */
    public function getOneByIdWithRelations($id)
    {
        return $this->setModel()::with(['user', 'school'])->find($id);
    }

    /**
     * Store a new student
     */
    public function store(array $data)
    {
        return $this->setModel()::create($data);
    }

    /**
     * Get students by school ID
     */
    public function getStudentsBySchool($schoolId)
    {
        return $this->setModel()::with(['user', 'school'])
            ->where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get students by grade
     */
    public function getStudentsByGrade($grade)
    {
        return $this->setModel()::with(['user', 'school'])
            ->where('grade', $grade)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Search students by student number or name
     */
    public function searchStudents($searchTerm)
    {
        return $this->setModel()::with(['user', 'school'])
            ->where('student_number', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function getCountStudentsBySchoolId($id): string
    {
        return $this->setModel()::where('school_id', $id)->pluck('id')->count();
    }

    public function getPaginateStudentsBySchoolId($id)
    {
        return $this->setModel()::where('school_id', $id)->orderBy('id', 'desc')->paginate(10);
    }
}
