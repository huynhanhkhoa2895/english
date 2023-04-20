<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticeStudentReceive extends Model
{
    use HasFactory;
    protected $table = "practice_student_receive";

    protected $fillable = [
        'practice_student_id',
        'point',
    ];

    public function practiceStudent(): BelongsTo
    {
        return $this->belongsTo(PracticeStudent::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(PracticeStudentResult::class,"practice_student_receive_id","id");
    }
}
