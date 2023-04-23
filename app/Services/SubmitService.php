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

    function submitPractice($dataResult): bool
    {
        try{
            $data["practice_student_id"] = $this->repoPractice->getByStudent(auth("api")->id(),"id")->id;
            $submit = $this->repo->create($data);
            if($submit) {
                $point = 0;
                $total = count($dataResult);
                foreach ($dataResult as $data) {
                    $data["practice_student_submit_id"] = $submit->id;
                    if($data['result']) {
                        $point++;
                    }
                    $this->resultService->createResult($data);
                }
                $submit->point = round(($point/$total),3)*10;
                $submit->question_title = $data['question_title'];
                $submit->save();
            }
            return true;
        } catch (Exception $exception) {
            dd($exception);
            Log::error("SubmitService: submitPractice - ".$exception->getMessage());
        }
        return false;
    }
}
