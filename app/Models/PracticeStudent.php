<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
class PracticeStudent extends Pivot
{
    use HasFactory;

    protected $table = "practice_student";
    protected $with = ['student','submits'];

    protected $fillable = [
        'due_date',
        'just_one_time',
        'created_at',
        'updated_at'
    ];

    function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }

    function submits(): HasMany
    {
        return $this->hasMany(PracticeStudentSubmit::class,"practice_student_id","id");
    }
}
