<?php

namespace App\Repositories;

use App\Models\VocabularyRelationship;
use Illuminate\Support\Collection;

class VocabularyRelationshipRepository extends BaseRepository
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->model = app(VocabularyRelationship::class);
    }

    public function getRelation($vocabulary,$relation,$select = ['*']){
        return $this->model->where("vocabulary_main",$vocabulary)->where("relationship",$relation)->get($select);
    }

    public function syncVocabulary($vocabulary1,$vocabulary2,$relationship){
        if(empty($this->model->where([
            ["vocabulary_main",$vocabulary1],
            ["vocabulary_relationship",$vocabulary2],
            ["relationship",$relationship],
        ])->first())){
            $this->model->create([
                "vocabulary_main"=>$vocabulary1,
                "vocabulary_relationship"=>$vocabulary2,
                "relationship"=>$relationship,
            ]);
        }
        if(empty($this->model->where([
            ["vocabulary_main",$vocabulary2],
            ["vocabulary_relationship",$vocabulary1],
            ["relationship",$relationship],
        ])->first())){
            $this->model->create([
                "vocabulary_main"=>$vocabulary2,
                "vocabulary_relationship"=>$vocabulary1,
                "relationship"=>$relationship,
            ]);
        }
    }
}
