<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vocabulary extends Model implements HasMedia
{
    use InteractsWithMedia;
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
        'category_id',
        'parts_of_speech',
        'definition',
        'created_at',
        'updated_at'
    ];

    function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,"category_id","id");
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)->withPivot("vocabulary_id");
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->using(StudentVocabulary::class)->withPivot('point', 'repeat');
    }

    public function exam(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class);
    }

    public function results(): MorphToMany
    {
        return $this->morphToMany(PracticeStudentResult::class, 'question');
    }

    public function vocabulary_relationship_main(): HasMany
    {
        return $this->hasMany(VocabularyRelationship::class,"vocabulary_main");
    }

    public function vocabulary_relationship_relationship(): HasMany
    {
        return $this->hasMany(VocabularyRelationship::class,"vocabulary_relationship");
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this
            ->addMediaConversion('image')
            ->nonQueued();
    }
}
