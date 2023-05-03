<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
class StudentVocabulary extends Pivot
{
    use HasFactory;

    protected $table = "student_vocabulary";

    protected $fillable = [
        'point',
        'repeat',
        'created_at',
        'updated_at'
    ];

    function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class);
    }
}
