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

    public function getNextAndPrev($vocabulary, $orderBy,$col = ['*']) : Collection{
        return $this->model
            ->selectRaw("
            SELECT row
            FROM
            (SELECT @rownum:=@rownum+1 row, a.*
            FROM articles a, (SELECT @rownum:=0) r
            ORDER BY date, id) as article_with_rows
            WHERE id = 50;
            ")
            ->get($col);
    }
}
