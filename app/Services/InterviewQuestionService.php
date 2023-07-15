<?php

namespace App\Services;

use App\Interface\InterviewQuestionInterface;
use Illuminate\Support\Collection;


class InterviewQuestionService implements InterviewQuestionInterface
{
    function __construct(private readonly InterviewQuestionRepository $repo)
    {

    }

    function getList(array $id = []): Collection
    {
        return $this->repo->getAll();
    }
}
