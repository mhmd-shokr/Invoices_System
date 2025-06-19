<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    protected $fillable = [
        'section_name',
        'description',
        'Created_by',
    ];


    public function products()
    {
        return $this->hasMany(products::class);
    }
    
   

}
