<?php
namespace App\Interface;

use App\Http\Resources\VocabularyCollection;
use App\Models\Vocabulary;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface VocabularyInterface{
    function getList(?string $relation,?string $id,?int $page,?int $limit): VocabularyCollection|false;
    function textToSpeach(string $text): string|false;
    function importFromExcel(string $excel): bool;
    function syncRelationship(string $idVocabulary1,string $idVocabulary2,string $relationship): bool;
    function validateVocabulary(string $vocabulary,string $part_of_speech, string|null $id): bool;
    function exportExcel(Collection $models, array $cols): BinaryFileResponse|false;
    function getNextPreviousVocabulary(Vocabulary $vocabulary,string $type = "next") : Vocabulary|false;
    function createVocabulary(Vocabulary $vocabulary) : Vocabulary|false;
}
