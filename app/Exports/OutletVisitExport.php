<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OutletVisitExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function forQuery($query, $headings)
    {
        $this->query = $query;
        $this->headings = $headings;
        
        return $this;
    }

    public function query()
    {
        return $this->query;
    }
    public function headings() :array
    {
        return $this->headings;
    }
}
