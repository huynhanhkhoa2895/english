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
}
