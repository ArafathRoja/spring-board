<?php

namespace App\Exports;

use App\Samples;
use Maatwebsite\Excel\Concerns\FromCollection;

class SamplesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Samples::all();
    }
}
