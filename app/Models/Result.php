<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    use HasFactory;
    protected $table = "result";

    protected $fillable = [
        'student_id',
        'question_id',
        'question_type',
        'correct_answer',
        'answer',
        'result'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
