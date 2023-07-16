<?php

namespace App\Observers;

use App\Interface\InterviewQuestionInterface;
use App\Models\InterviewQuestion;

class InterviewQuestionObserver
{
    public function saved(InterviewQuestion $interviewQuestion): void
    {
        $interviewQuestionService = app(InterviewQuestionInterface::class);
        if($path = $interviewQuestionService->textToSpeach($interviewQuestion)){
            if($interviewQuestion->sound !== $path) {
                $v = InterviewQuestion::find($interviewQuestion->id);
                $v->sound = $path;
                $v->save();
            }
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
