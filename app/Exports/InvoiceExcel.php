<?php

namespace App\Exports;

use App\Models\Invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoiceExcel implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoices::all();
    }
}
