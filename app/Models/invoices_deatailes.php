<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoices_deatailes extends Model
{
    protected $fillable=[
        'invoice_id',
        'invoice_number',
        'product',
        'section',
        'note',
        'value_status',
        'total',
        'status',
        'user',
        'payment_date'
    ];
    
}
