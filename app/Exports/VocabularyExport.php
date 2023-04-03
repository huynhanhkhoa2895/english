<?php

namespace App\Exports;

use App\Models\Vocabulary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class VocabularyExport implements FromCollection
{
    public function __construct(private Collection $invoices)
    {
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->invoices;
    }
}
