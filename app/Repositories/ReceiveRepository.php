<?php

namespace App\Repositories;

use App\Models\PracticeStudentReceive;

class ReceiveRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(PracticeStudentReceive::class);
    }
}
