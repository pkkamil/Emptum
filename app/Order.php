<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function cart() {
        return $this->belongsTo('App\Cart');
    }

    public function deliveryPlace() {
        return $this->belongsTo('App\DeliveryPlace', 'deliveryPlace_id');
    }
}
