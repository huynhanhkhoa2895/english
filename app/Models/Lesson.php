<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;
    protected $table = "lesson";
    protected $fillable = [
        'name',
    ];
    public function vocabularies(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class)->withPivot("lesson_id");
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withPivot("lesson_id");
    }
}
