<?php

namespace App\Observers;

use App\Interface\VocabularyInterface;
use App\Models\Vocabulary;

class VocabularyObserver
{
    public function saved(Vocabulary $vocabulary): void
    {
        $vocabularyService = app(VocabularyInterface::class);
        if($path = $vocabularyService->textToSpeach(trim($vocabulary->vocabulary))) {
            if($vocabulary->sound !== $path) {
                $v = Vocabulary::find($vocabulary->id);
                $v->sound = $path;
                $v->save();
            }

        }
    }

    /**
     * Handle the Vocabulary "deleted" event.
     */
    public function deleted(Vocabulary $vocabulary): void
    {
        //
    }

    /**
     * Handle the Vocabulary "restored" event.
     */
    public function restored(Vocabulary $vocabulary): void
    {
        //
    }

    /**
     * Handle the Vocabulary "force deleted" event.
     */
    public function forceDeleted(Vocabulary $vocabulary): void
    {
        //
    }
}
