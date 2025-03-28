<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Lesson extends Model
{
    use HasFactory;
    protected $table = "lesson";
    protected $fillable = [
        'name',
    ];

    public function vocabularySynonyms(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class)->withPivot("lesson_id")->with('vocabulary_relationship_main',function ($query){
            return $query->where('relationship','synonyms');
        });
    }

    public function vocabularies(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class)->withPivot("lesson_id")->with('vocabulary_relationship_main');
    }


    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withPivot("lesson_id");
    }

    public function interviewQuestions(): BelongsToMany
    {
        return $this->belongsToMany(InterviewQuestion::class,"lesson_interview_question")->withPivot("lesson_id");
    }

    public function listenings(): BelongsToMany
    {
        return $this->belongsToMany(Listening::class,"lesson_listening")->withPivot("lesson_id");
    }

}
