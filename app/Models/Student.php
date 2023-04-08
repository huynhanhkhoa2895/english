<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $table = "student";

    protected $fillable = [
        'name',
        'email',
        'position',
        'password',
    ];

    public function vocabularies(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class)->withPivot("student_id");
    }
}
