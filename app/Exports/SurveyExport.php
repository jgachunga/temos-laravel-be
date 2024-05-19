<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyExport implements FromArray, WithHeadings
{
    public function forQuery($query, $headings)
    {
        $this->query = $query;
        $this->headings = $headings;
        return $this;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->query;
    }
    public function headings() :array
    {
        return $this->headings;
    }
}
