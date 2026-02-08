<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //

      protected $fillable = [
        'order_id',
        'paper_id',
        'price'
    ];

    public function order(){
        return $this->belongsTo(Order::class , 'order_id');
    }


     public function paper(){
        return $this->belongsTo(Paper::class , 'paper_id');
    }
}


