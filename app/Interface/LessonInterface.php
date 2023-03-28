<?php
namespace App\Interface;

use App\Models\Lesson;
use Illuminate\Support\Collection;

interface LessonInterface{
    function getList(): Collection;
    function getById(string $id): Lesson;
}
