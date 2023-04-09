<?php

namespace App\Services;

use App\Interface\PracticeInterface;
use App\Models\Practice;
use App\Repositories\LessonRepository;
use App\Repositories\VocabularyRepository;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;

class PracticeService implements PracticeInterface
{
    function __construct(private readonly PracticeRepository $repo)
    {

    }

    function getList(): Collection
    {
        return $this->repo->getAll()->load("questions");
    }

    function getById(string $id): Practice
    {
        return $this->repo->find($id);
    }
}
