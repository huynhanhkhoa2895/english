<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class PracticeQuestionContent extends Model
{
    use HasFactory;
    protected $table = "practice_question_content";

    protected $fillable = [
        'answer',
        'question',
        'values'
    ];

    protected $casts = [
        'values' => 'array',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }

    public function results(): MorphToMany
    {
        return $this->morphToMany(PracticeStudentResult::class, 'question');
    }
}
