<?php

namespace App\Services;

use App\Interface\ResultInterface;
use App\Models\Result;
use App\Repositories\ResultRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class ResultService implements ResultInterface
{
    function __construct(private readonly ResultRepository $repo){

    }

    function createResult($data): Result|false
    {
        try{
            $data["student_id"] = auth("api")->id();
            return $this->repo->create($data);
        } catch (Exception $exception) {
            Log::error("ResultService: createResult - ".$exception->getMessage());
        }
        return false;
    }
}
