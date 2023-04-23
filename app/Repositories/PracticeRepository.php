<?php

namespace App\Repositories;

use App\Models\Practice;
use App\Models\PracticeStudent;
use App\Models\PracticeStudentSubmit;
use App\Repositories\BaseRepository;

class PracticeRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(Practice::class);
    }

    public function getByStudent($student_id,$cols = ['*']) {
        return PracticeStudent::where("student_id",$student_id)->select($cols)->first();
    }

    public function getListByStudent($studentId){
        return $this->students()->wherePivot("student_id",$studentId)->get();
    }

    public function getResult($practice_id) {
        $practiceStudents = PracticeStudent::where("practice_id",$practice_id)->get();
        return $practiceStudents->map(function (PracticeStudent $practiceStudent){
            return [
                "student_name" => $practiceStudent->student->name,
                "submits" => $practiceStudent->submits->map(fn (PracticeStudentSubmit $submit) => $submit)
            ];
        });

    }
}
