<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
      'name',
      'description',
      'semester',
      'lecturer_id'
    ];

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }
}
