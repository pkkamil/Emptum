<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryPlace extends Model
{
    public $timestamps = false;

    public function orders() {
        return $this->hasMany('App\Order', 'deliveryPlace_id');
    }
}
