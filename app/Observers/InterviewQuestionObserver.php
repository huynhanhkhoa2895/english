<?php

namespace App\Observers;

use App\Interface\InterviewQuestionInterface;
use App\Models\InterviewQuestion;
use Storage;
use Str;

class InterviewQuestionObserver
{
    public function saved(InterviewQuestion $interviewQuestion): void
    {
        $interviewQuestionService = app(InterviewQuestionInterface::class);
        $nameFile = Str::slug($interviewQuestion->question);
        if(!Storage::disk('interview')->exists($nameFile.'.mp3')){
            $interviewQuestionService->textToSpeach($interviewQuestion);
        }

    }
    /**
     * Handle the InterviewQuestion "created" event.
     */
    public function created(InterviewQuestion $interviewQuestion): void
    {
        //
    }

    /**
     * Handle the InterviewQuestion "updated" event.
     */
    public function updated(InterviewQuestion $interviewQuestion): void
    {
        //
    }

    /**
     * Handle the InterviewQuestion "deleted" event.
     */
    public function deleted(InterviewQuestion $interviewQuestion): void
    {
        //
    }

    /**
     * Handle the InterviewQuestion "restored" event.
     */
    public function restored(InterviewQuestion $interviewQuestion): void
    {
        //
    }

    /**
     * Handle the InterviewQuestion "force deleted" event.
     */
    public function forceDeleted(InterviewQuestion $interviewQuestion): void
    {
        //
    }
}
