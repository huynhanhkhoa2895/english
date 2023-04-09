<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeQuestionContent extends Model
{
    use HasFactory;
    protected $table = "practice_question_content";

    protected $fillable = [
        'answer',
        'question',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }
}
