<?php

namespace App\Services;

use App\Interface\SubmitInterface;
use App\Interface\ResultInterface;
use App\Repositories\PracticeRepository;
use App\Repositories\SubmitRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class SubmitService implements SubmitInterface
{
    function __construct(private readonly SubmitRepository $repo,private readonly PracticeRepository $repoPractice, private readonly ResultInterface $resultService){

    }

    function submitPractice($datas): bool
    {
        try{
            $dataResult = collect($datas['data']);
            $data["practice_student_id"] = $this->repoPractice->getByStudent($datas['practice_id'],auth("api")->id(),"id")->id;
            $data["question_title"] = $datas['question_title'];
            $submit = $this->repo->create($data);

            if($submit) {
                $point = 0;
                $total = count($dataResult);
                foreach ($dataResult as $data) {
                    $data["practice_student_submit_id"] = $submit->id;

                    $data["question_type"] = $datas['question_type'];
                    if($data['result']) {
                        $point++;
                    }
                    $this->resultService->createResult($data);
                }
                $submit->point = round(($point/$total),3)*10;
                $submit->save();
            }
            return true;
        } catch (Exception $exception) {
            Log::error("SubmitService: submitPractice - ".$exception->getMessage());
        }
        return false;
    }
}
