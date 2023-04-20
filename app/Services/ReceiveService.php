<?php

namespace App\Services;

use App\Interface\ReceiveInterface;
use App\Interface\ResultInterface;
use App\Repositories\ReceiveRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class ReceiveService implements ReceiveInterface
{
    function __construct(private readonly ReceiveRepository $repo, private readonly ResultInterface $resultService){

    }

    function receivePractice($dataResult): bool
    {
        try{
            $data["practice_student_id"] = auth("api")->id();
            $receive = $this->repo->create($data);
            if($receive) {
                $point = 0;
                $total = count($dataResult);
                foreach ($dataResult as $data) {
                    $data["practice_student_receive_id"] = $receive->id;
                    if($data['result']) {
                        $point++;
                    }
                    $this->resultService->createResult($data);
                }
                $receive->point = round(($point/$total),3)*10;
                $receive->save();
            }
            return true;
        } catch (Exception $exception) {
            dd($exception);
            Log::error("ReceiveService: receivePractice - ".$exception->getMessage());
        }
        return false;
    }
}
