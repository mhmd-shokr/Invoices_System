<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoices_attachement extends Model
{
    protected $fillable = [
        'file_name',
        'invoice_id',
        'invoice_number',
        'Created_by',
        
    ];

    public function invoice(){
        return $this->belongsTo(invoices::class,'invoice_id');
    }
}
