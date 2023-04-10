<?php

namespace App\Services;

use App\Interface\PracticeInterface;
use App\Repositories\PracticeRepository;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PraticeResource;

class PracticeService implements PracticeInterface
{
    function __construct(private readonly PracticeRepository $repo)
    {

    }

    function getList(): Collection
    {
        return $this->repo->getAll()->load("questions");
    }

    function getById(string $id): PraticeResource|false
    {
        try{
            return new PraticeResource($this->repo->find($id)->load("questions"));
        } catch (Exception $exception) {
            Log::error("PracticeService: getById - ".$exception->getMessage());
        }
        return false;

    }
}
