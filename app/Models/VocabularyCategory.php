<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VocabularyCategory extends Pivot
{
    protected $table = "vocabulary_category";
    protected $with = ['vocabulary'];

    function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class);
    }

    function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
