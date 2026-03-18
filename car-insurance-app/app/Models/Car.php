<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'reg_number',
        'brand',
        'owner_id',
        'model',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
