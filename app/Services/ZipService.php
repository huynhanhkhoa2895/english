<?php

namespace App\Services;

use App\Interface\ZipInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ZipService implements ZipInterface
{
    protected string | null $disk = null;

    function setDisk($disk) : void {
        $this->disk = $disk;
    }

    function zipFile(array $paths,string $nameFileZip,?string $disk): string|false
    {
        // TODO: Implement zipFile() method.
        try{
            $zip = new \ZipArchive();
            $zip->open(Storage::disk("zip")->path($nameFileZip.".zip"), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            foreach ($paths as $path) {
                $zip->addFile(!empty($disk) ? Storage::disk($disk)->path($path) : $path, $path);
            }
            $zip->close();
            return Storage::disk("zip")->path($nameFileZip.".zip");
        }catch (Exception $exception){
            dd($exception);
            Log::error("ZipService: zipFile - ".$exception->getMessage());
            return false;
        }
    }
}
