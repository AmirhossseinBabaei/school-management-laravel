<?php

namespace App\Repositories;

use App\Models\StudyField;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class StudyFieldsRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('study_fields');
    }

    protected function setModel()
    {
        return StudyField::class;
    }

    public function getParentStudyFieldsByPaginate()
    {
        return $this->setModel()::where('parent_id', NULL)->orderBy('id', 'desc')->paginate(10);
    }

    public function getChildrenStudyFields($id)
    {
        return $this->setModel()::where('parent_id', $id)->orderBy('id', 'desc')->paginate(10);
    }

    public function getOneById($id)
    {
        return $this->setModel()::find($id);
    }

    public function getStudyFieldsBySchoolId($schoolId)
    {
        return $this->setModel()::where('school_id', $schoolId)->orderBy('id', 'desc')->get();
    }
}
