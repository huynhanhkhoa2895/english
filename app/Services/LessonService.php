<?php

namespace App\Services;

use App\Interface\LessonInterface;
use App\Models\Lesson;
use App\Models\Vocabulary;
use App\Models\VocabularyRelationship;
use App\Repositories\LessonRepository;
use App\Repositories\VocabularyRepository;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;
use DB;

class LessonService implements LessonInterface
{
    function __construct(private readonly LessonRepository $repo, private readonly VocabularyRepository $vocaRepo){

    }

    function getList(array $id = []): Collection
    {
        return $this->repo->getAll()->load("vocabularies");
    }

    function getById(string|array $id): Lesson
    {
        if(is_array($id)){
            return $this->repo->getAllWithId($id)->load("vocabularies");
        }else{
            return $this->repo->find($id);
        }

    }

    function attachVocabulary(string $from,mixed $data,$model): bool
    {
        try{
            $vocabulary = $this->vocaRepo->getByDate($data,['id'])->map(function(Vocabulary $model){
                return $model->id;
            });
            $model->vocabularies()->syncWithoutDetaching($vocabulary->toArray());
            return true;
        } catch (Exception $exception) {
            Log::error("LessonService: attachVocabulary - ".$exception->getMessage());
        }
        return false;

    }

    function preparePracticeTimeout(string $id): Collection
    {
        try{
            $allVoca = $this->vocaRepo
                ->getModel()
                ->whereNotNull("translate")
                ->get(["id","vocabulary","translate"]);
            $total = $allVoca->count();
            $lesson = $this->repo->find($id)->load("vocabularySynonyms");
            return $lesson->vocabularySynonyms->map(function($item) use ($total, $allVoca) {
                $indexCorrect = rand(0,3);
                $listVocabularySynonyms = $item->vocabulary_relationship_main->map(fn (VocabularyRelationship $vocaRelationship)=>$vocaRelationship->vocabulary_relationship)->toArray();
                $values = ["","","",""];
                foreach ($values as $index=>$value){
                    if($indexCorrect === $index){
                        $values[$index] = [
                            "id"=>$item->id,
                            "vocabulary"=>$item->vocabulary,
                            "translate"=>$item->translate,

                        ];
                    }else{
                        $voca = $allVoca[rand(0,$total-1)];
                        while (
                            in_array($voca->translate,$values) ||
                            empty($voca->translate) ||
                            $voca->vocabulary === $item->vocabulary ||
                            in_array($voca->id,$listVocabularySynonyms)
                        ){
                            $voca = $allVoca[rand(0,$total-1)];
                        }
                        $values[$index] = [
                            "id"=>$voca->id,
                            "vocabulary"=>$voca->vocabulary,
                            "translate"=>$voca->translate,
                        ];
                    }
                }
                return [
                    "question"=>[
                        "id"=>$item->id,
                        "vocabulary"=>$item->vocabulary,
                        "translate"=>$item->translate,
                        "parts_of_speech"=>$item->parts_of_speech
                    ],
                    "values"=>$values
                ];
            });
        } catch (Exception $exception) {
            Log::error("LessonService: preparePracticeTimeout - ".$exception->getMessage());
        }
        return collect();

    }
}
