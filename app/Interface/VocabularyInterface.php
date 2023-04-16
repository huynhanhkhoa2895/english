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
    function exportExcel(Collection $models, array $cols): BinaryFileResponse|false;
    function getNextPreviousVocabulary(Vocabulary $vocabulary,string $type = "next") : Vocabulary|false;
}
