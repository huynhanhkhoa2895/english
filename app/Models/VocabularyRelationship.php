<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocabularyRelationship extends Model
{
    protected $table = "vocabulary_relationship";
    use HasFactory;
    protected $fillable = [
        'vocabulary_main',
        'vocabulary_relationship',
        'relationship'
    ];

    public function vocabulary_main_vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class,"vocabulary_main","id");
    }
    public function vocabulary_relationship_vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class,"vocabulary_relationship","id");
    }
}
