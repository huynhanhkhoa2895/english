<?php

namespace App\Services;

use App\Interface\LessonInterface;
use App\Models\Lesson;
use App\Models\Vocabulary;
use App\Repositories\LessonRepository;
use App\Repositories\VocabularyRepository;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;

class LessonService implements LessonInterface
{
    function __construct(private readonly LessonRepository $repo, private readonly VocabularyRepository $vocaRepo){

    }

    function getList(): Collection
    {
        return $this->repo->getAll()->load("vocabularies");
    }

    function getById(string $id): Lesson
    {
        return $this->repo->find($id);
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
            $allVoca = $this->vocaRepo->getModel()->whereNotNull("translate")->get(["vocabulary","translate"]);
            $total = $allVoca->count();
            $lesson = $this->repo->find($id)->load("vocabularies");
            return $lesson->vocabularies->map(function($item) use ($total, $allVoca) {
                $indexCorrect = rand(0,3);
                $values = ["","","",""];
                foreach ($values as $index=>$value){
                    if($indexCorrect === $index){
                        $values[$index] = $item;
                    }else{
                        $voca = $allVoca[rand(0,$total)];
                        while (in_array($voca->translate,$values) || empty($voca->translate) || $voca->vocabulary === $item->vocabulary){
                            $voca = $allVoca[rand(0,$total)];
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
