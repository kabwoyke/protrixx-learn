<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    //
      protected $fillable = [
        'name'
    ];


    public function paper(){
        return $this->hasMany(Paper::class);
    }
}

