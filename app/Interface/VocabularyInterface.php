<?php
namespace App\Interface;

interface VocabularyInterface{
    function getList(): array|false;
    function textToSpeach(string $text): string|false;
    function importFromExcel(string $excel): bool;
}
