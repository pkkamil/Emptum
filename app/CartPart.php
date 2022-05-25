<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartPart extends Model
{
    protected $table = 'carts_products';

    public function product() {
        return $this->belongsTo('App\Product');
    }
}
