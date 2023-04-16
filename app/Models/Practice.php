<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Practice extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $table = "practice";

    protected $fillable = [
        'name',
        'level',
        'type',
        'instructions',
        'media',
        'content',
        'link_video'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(PracticeQuestion::class,"practice_id","id");
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->using(PracticeStudent::class)->withPivot("due_date");
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this
            ->addMediaConversion('media')
            ->nonQueued();
    }
}
