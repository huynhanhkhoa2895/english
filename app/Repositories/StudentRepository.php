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

    public function getListVocabulary($id,$page,$limit,$sort){
        if(empty($sort)) {
            $sort = [
                "field" => "vocabulary",
                "direction" => "desc"
            ];
        }
        $model = $this->model
            ->where("id",$id)
            ->first()
            ->vocabularies();
        $count = $model->count();
        $data = $model
            ->offset(($page-1)*$limit)
            ->limit($limit)
            ->orderBy($sort['field'],$sort['direction'])
            ->get();
        return [
            "count" => $count,
            "data" => $data
        ];
    }
}
