<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vocabulary extends Model
{
    use HasFactory;
    protected $table = "vocabulary";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vocabulary',
        'spelling',
        'translate',
        'example',
        'sound',
        'category_id'
    ];

    function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,"category_id","id");
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)->withPivot("vocabulary_id");
    }

    public function exam(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class);
    }
}
