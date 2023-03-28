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
}
