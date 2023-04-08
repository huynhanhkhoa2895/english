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

    function zipFile(array $paths,string $nameFileZip,string|array $disk): string|false
    {
        // TODO: Implement zipFile() method.
        try{
            $zip = new \ZipArchive();
            $zip->open(Storage::disk("zip")->path($nameFileZip.".zip"), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            foreach ($paths as $key=>$path) {
                if($path !== null){
                    $pathGetFile = !is_array($disk) ? Storage::disk($disk)->path($path) : Storage::disk($disk[$key])->path($path);
                    if(is_file($pathGetFile)){
                        $zip->addFile($pathGetFile, $path);
                    }
                }
            }
            $zip->close();
            return $nameFileZip.".zip";
        }catch (Exception $exception){
            dd($exception);
            Log::error("ZipService: zipFile - ".$exception->getMessage());
            return false;
        }
    }
}
