<?php

namespace App\Services;

use App\Interface\ResultInterface;
use App\Repositories\ResultRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class ResultService implements ResultInterface
{
    function __construct(private readonly ResultRepository $repo){

    }

    function createResult($data): bool
    {
        try{
            $data["student_id"] = auth("api")->id();
            return (bool)$this->repo->create($data);
        } catch (Exception $exception) {
            Log::error("ResultService: createResult - ".$exception->getMessage());
        }
        return false;
    }
}
