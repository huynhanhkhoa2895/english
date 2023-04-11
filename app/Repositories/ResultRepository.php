<?php

namespace App\Repositories;

use App\Models\Result;
use App\Repositories\BaseRepository;

class ResultRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(Result::class);
    }
}
