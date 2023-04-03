<?php
namespace App\Interface;

use App\Models\Lesson;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface LessonInterface{
    function getList(): Collection;
    function getById(string $id): Lesson;
    function attachVocabulary(string $from,mixed $data,Model $model): bool;
}
