<?php

namespace App\Repositories;

use App\Models\Vocabulary;
use App\Repositories\BaseRepository;

class VocabularyRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(Vocabulary::class);
    }
}
