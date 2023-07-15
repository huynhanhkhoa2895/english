<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InterviewQuestion extends Model
{
    use HasFactory;
    protected $table = "interview_question";

    protected $casts = [
        'tags' => 'array',
    ];

    protected $fillable = [
        'question',
        'answer',
        'tags'
    ];

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class,"lesson_interview_question")->withPivot("interview_question_id");
    }
}
