<?php

namespace App\Imports;

use App\Models\Vocabulary;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Exception;
class VocabularyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            if(!empty($row[0])){
                return Vocabulary::updateOrCreate([
                    'vocabulary'     => trim($row[0])
                ],[
                    'translate'    => $row[1] ?? '',
                    'example'    => $row[2] ?? null,
                ]);;
            }
        } catch (Exception $e) {
            Log::error("VocabularyImport: model - ".$e->getMessage());
        }

    }
}
