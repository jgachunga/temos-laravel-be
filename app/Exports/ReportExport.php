<?php
namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromQuery, WithHeadings
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