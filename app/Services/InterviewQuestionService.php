<?php

namespace App\Services;

use App\Interface\GoogleInterface;
use App\Interface\InterviewQuestionInterface;
use App\Models\InterviewQuestion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Repositories\InterviewQuestionRepository;
use Str;

class InterviewQuestionService implements InterviewQuestionInterface
{
    function __construct(private readonly InterviewQuestionRepository $repo,protected GoogleInterface $googleService)
    {

    }

    function getList(array $id = []): Collection
    {
        return $this->repo->getAll();
    }

    function textToSpeach(InterviewQuestion $interviewQuestion): string|false
    {
        try {
            $nameFile = Str::slug($interviewQuestion->question);
            if(!empty($interviewQuestion->question)){
                $this->googleService->callApiGoogle($interviewQuestion->question ?? "",$nameFile."-question","interview");
                return $nameFile."-question".'.mp3';
            }
//            if(!empty($interviewQuestion->answer)){
//                $this->googleService->callApiGoogle($interviewQuestion->answer ?? "",$nameFile."-answer","interview");
//                return $nameFile."-answer".'.mp3';
//            }
            return false;
        } catch (Exception $exception) {
            Log::error("InterviewQuestionService: textToSpeach - ".$exception->getMessage());
            return false;
        }
    }
}
