<?php

namespace App\Services;

use App\Interface\LessonInterface;
use App\Models\Lesson;
use App\Repositories\LessonRepository;
use Illuminate\Support\Collection;

class LessonService implements LessonInterface
{
    function __construct(private readonly LessonRepository $repo){

    }

    function getList(): Collection
    {
        return $this->repo->getAll()->load("vocabularies");
    }

    function getById(string $id): Lesson
    {
        return $this->repo->find($id);
    }
}
