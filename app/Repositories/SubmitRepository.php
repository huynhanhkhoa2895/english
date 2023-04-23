<?php

namespace App\Repositories;

use App\Models\PracticeStudentSubmit;

class SubmitRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(PracticeStudentSubmit::class);
    }
}
