<?php

namespace App\Models;

use App\Models\PracticeQuestionContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Student extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = "student";

    protected $fillable = [
        'name',
        'email',
        'position',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function vocabularies(): BelongsToMany
    {
        return $this->belongsToMany(Vocabulary::class)->using(StudentVocabulary::class)->withPivot('point', 'repeat');
    }

    public function practices(): BelongsToMany
    {
        return $this->belongsToMany(Practice::class)->withPivot("student_id","due_date");
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)->withPivot("student_id");
    }

    public function resultQuestion(): MorphToMany
    {
        return $this->morphedByMany(PracticeQuestionContent::class, 'question','result')->withPivot('result','correct_answer','answer');
    }

    public function resultVocabularies(): MorphToMany
    {
        return $this->morphedByMany(Vocabulary::class, 'question','result')->withPivot('result','correct_answer','answer');;
    }


    public function results(): HasMany
    {
        return $this->hasMany(PracticeStudentResult::class);
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
