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
                $match = [];
                $vocal = $row[0];
                $parts_of_speech = "";
                preg_match("#(.*)(\((.*?)\))#",$row[0],$match);

                if(!empty($match)){
                    $parts_of_speech = $match[3] ?? "";
                    $vocal = $match[1] ?? "";
                }

                return Vocabulary::updateOrCreate([
                    'vocabulary'     => trim($vocal)
                ],[
                    'translate'    => $row[1] ?? '',
                    'example'    => $row[2] ?? null,
                    'parts_of_speech' => $parts_of_speech
                ]);;
            }
        } catch (Exception $e) {
            Log::error("VocabularyImport: model - ".$e->getMessage());
        }

    }
}
