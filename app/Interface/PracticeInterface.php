<?php
namespace App\Interface;

use App\Http\Resources\PraticeResource;
use Illuminate\Support\Collection;

interface PracticeInterface{
    function getList(): Collection;
    function getById(string $id): PraticeResource|false;
    function createVocabularyPractice(array $data): PraticeResource|false;
}
