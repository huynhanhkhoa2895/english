<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(Student::class);
    }

    public function getListPractice($studentId){
        return $this->where("student",$studentId)->first()->practices;
    }
}
