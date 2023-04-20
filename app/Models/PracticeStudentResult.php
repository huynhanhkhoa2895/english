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
        'question',
        'correct_answer',
        'answer',
        'result'
    ];

    public function practiceStudentReceive(): BelongsTo
    {
        return $this->belongsTo(PracticeStudentReceive::class);
    }
}
