<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArrayExport implements FromArray, WithHeadings
{
    public function __construct($data, $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->data;
    }
    public function headings() :array
    {
        return $this->headings;
    }
}
