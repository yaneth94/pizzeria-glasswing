<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['amount'];
    public function pizzas(){
        return $this->belongsToMany(Pizza::class,'order_details','order_id','pizza_id');
    }

}
