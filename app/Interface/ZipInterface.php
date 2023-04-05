<?php
namespace App\Interface;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ZipInterface{
    function setDisk(string $disk): void;
    function zipFile(array $paths, string $nameFileZip,?string $disk): string|false;
}
