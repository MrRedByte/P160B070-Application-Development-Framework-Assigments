<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public function subjects(){
        return $this->hasMany(Subject::class);
    }
}
