<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticeQuestion extends Model
{
    use HasFactory;
    protected $table = "practice_question";

    protected $fillable = [
        'practice_id',
        'title',
        'type',
        'description',
    ];

    public function contents(): HasMany
    {
        return $this->hasMany(PracticeQuestionContent::class,"question_id","id");
    }

    public function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }
}
