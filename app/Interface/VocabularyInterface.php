<?php
namespace App\Interface;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface VocabularyInterface{
    function getList(): array|false;
    function textToSpeach(string $text): string|false;
    function importFromExcel(string $excel): bool;
    function exportExcel(Collection $models, array $cols): BinaryFileResponse|false;
}
