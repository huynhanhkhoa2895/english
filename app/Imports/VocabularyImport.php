<?php

namespace App\Imports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\ToModel;

class VocabularyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Vocabulary::updateOrCreate([
            'vocabulary'     => $row[0]
        ],[
            'translate'    => $row[1] ?? '',
            'example'    => $row[2] ?? '',
        ]);
    }
}
