<?php

namespace App\Repositories;

use App\Models\Practice;
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

    public function getListByStudent($studentId){
        return $this->students()->wherePivot("student_id",$studentId)->get();
    }
}
