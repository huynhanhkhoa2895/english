<?php

namespace App\Repositories;

use App\Models\InterviewQuestion;
use App\Repositories\BaseRepository;

class InterviewQuestionRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(InterviewQuestion::class);
    }
}
