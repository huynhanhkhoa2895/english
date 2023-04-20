<?php

namespace App\Repositories;

use App\Models\PracticeStudentResult;
use App\Repositories\BaseRepository;

class ResultRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(PracticeStudentResult::class);
    }
}
