<?php

namespace App\Repositories;

use App\Models\Lesson;
use App\Repositories\BaseRepository;

class LessonRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(Lesson::class);
    }

    public function getAllWithId(array $id,$cols = ['*'])
    {
        return $this->model->whereIn("id",$id)->get($cols);
    }

    public function syncVocabulary($data)
    {
        return $this->model->vocabularies()->syncWithoutDetaching($data);
    }
}
