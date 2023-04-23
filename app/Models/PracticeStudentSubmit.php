<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticeStudentSubmit extends Model
{
    use HasFactory;
    protected $table = "practice_student_submit";
    protected $with = ['results'];
    protected $fillable = [
        'question_title',
        'practice_student_id',
        'point',
    ];

    public function practiceStudent(): BelongsTo
    {
        return $this->belongsTo(PracticeStudent::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(PracticeStudentResult::class,"practice_student_submit_id","id");
    }
}
