<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    use HasFactory;
    protected $table = "exam";
    public function vocabularies(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class);
    }
}
