namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class CustomersExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Customer::query()->whereYear('created_at', $this->year);
    }
}
