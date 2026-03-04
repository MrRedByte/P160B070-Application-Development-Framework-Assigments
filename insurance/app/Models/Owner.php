<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    // Bu alanlar topluca doldurulabilir
    protected $fillable = ['name', 'surname'];

    // Owner'ın sahip olduğu arabalar
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
