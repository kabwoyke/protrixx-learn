<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    //

      protected $fillable = [
        'title',
        'category_id',
        'grade_level_id',
        'year',
        'price',
        'file_path',
        'preview_path',
        'type'
    ];


    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }

     public function order(){
        return $this->hasMany(Order::class , 'order_id');
    }

     public function order_item(){
        return $this->hasMany(OrderItem::class);
    }

    public function grade_level(){
        return $this->belongsTo(GradeLevel::class);
    }
}
