<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
