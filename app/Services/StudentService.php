<?php

namespace App\Services;

use App\Http\Resources\StudentResource;
use App\Http\Resources\VocabularyCollection;
use App\Interface\StudentInterface;
use App\Repositories\StudentRepository;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class StudentService implements StudentInterface
{
    function __construct(private readonly StudentRepository $repo)
    {

    }

    function getList(): Collection
    {
        return $this->repo->getAll()->load("questions");
    }

    function handle(Request $request, string $id): mixed
    {
        return match ($request->type) {
            "vocabulary" => $this->getVocabularies($id,$request->page, $request->limit, $request->sort),
            default => $this->getById($id),
        };
    }

    private function getVocabularies(string $id,int $page,int $limit,array|null $sort): array|bool
    {
        try{
            $data = $this->repo->getListVocabulary($id,$page,$limit,$sort);
            return [
                "data" => new VocabularyCollection($data["data"]),
                "total" => $data["count"]
            ];
        } catch (Exception $exception) {
            Log::error("StudentService: getVocabularies - ".$exception->getMessage());
            return false;
        }
    }

    private function getById(string $id): StudentResource | false
    {
        try{
            return new StudentResource($this->repo->find($id)
                ->load("lessons")
                ->load("practices")
            );
        } catch (Exception $exception) {
            Log::error("StudentService: getById - ".$exception->getMessage());
        }
        return false;
    }
}
