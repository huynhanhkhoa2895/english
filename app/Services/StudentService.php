<?php

namespace App\Services;

use App\Http\Resources\StudentResource;
use App\Interface\StudentInterface;
use App\Repositories\StudentRepository;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;

class StudentService implements StudentInterface
{
    function __construct(private readonly StudentRepository $repo)
    {

    }

    function getList(): Collection
    {
        return $this->repo->getAll()->load("questions");
    }

    function getById(string $id): StudentResource | false
    {
        try{
            return new StudentResource($this->repo->find($id)->load("lessons")->load("practices"));
        } catch (Exception $exception) {
            Log::error("StudentService: getById - ".$exception->getMessage());
        }
        return false;
    }
}
