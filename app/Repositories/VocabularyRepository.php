<?php

namespace App\Repositories;

use App\Models\Vocabulary;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

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

    public function getByDate($date,$col = ['*']) : Collection{
        return $this->model->whereDate("created_at",$date)->get($col);
    }
}
