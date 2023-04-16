<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
class PracticeStudent extends Pivot
{
    use HasFactory;

    protected $table = "practice_student";

    protected $fillable = [
        'due_date',
    ];

    function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }
}
