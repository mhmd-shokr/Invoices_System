<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class invoices extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'invoices_date',
        'due_date',
        'product',
        'section_id',
        'Ammount_collection',
        'Ammount_commission',
        'discount',
        'value_vat',
        'rat_vat',
        'total',
        'status',
        'note',
        'payment_date',
        'value_status',
        'status',
        'user',

    ];

    //soft delete
    protected $dates=['deleted_at'];

    //relation one to many

    
    public function section()
    {
        return $this->belongsTo(sections::class);
    }
        public function attachements(){

            return $this->hasMany(invoices_attachement::class);
        }
        public function getStatusNameAttribute()
{
    return match($this->value_status) {
        1 => 'مدفوعة',
        2 => 'غير مدفوعة',
        3 => 'مدفوعة جزئياً',
        default => 'غير معروف',
    };
}

}
 