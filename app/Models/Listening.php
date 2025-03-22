<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Listening extends Model
{
    use HasFactory;
    protected $table = "listening";


    protected $fillable = [
        'name',
        'sound',
        'script'
    ];

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class,"lesson_listening")->withPivot("lesson_listening_id");
    }
}
