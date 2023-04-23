<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeStudentResult extends Model
{
    use HasFactory;
    protected $table = "practice_student_result";

    protected $fillable = [
        'practice_student_submit_id',
        'question_type',
        'question',
        'correct_answer',
        'answer',
        'result'
    ];

    public function PracticeStudentSubmit(): BelongsTo
    {
        return $this->belongsTo(PracticeStudentSubmit::class);
    }
}
