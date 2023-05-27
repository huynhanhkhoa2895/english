<?php

namespace App\Repositories;

use App\Models\Vocabulary;
use App\Models\VocabularyRelationship;
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

    public function getNextPrevious($id,$type = "next"): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null
    {
        return $this->model->where("id",$type === "next" ? "<" : ">",$id)->orderBy("id",$type === "next" ? "desc" : "asc")->first();
    }

    public function getVocabularyByPartOfSpeech($vocabulary,$part_of_speech): \Illuminate\Database\Eloquent\Model|null {
        return $this
                ->model
                ->where("parts_of_speech",$part_of_speech)
                ->where("vocabulary",$vocabulary)
                ->first();
    }
}
