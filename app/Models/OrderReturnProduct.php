<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderReturnProduct extends Pivot
{
    protected $fillable = [
        'order_return_id',
        'product_id',
        'price',
        'gram_price',
        'sale_manufacturing_value'
    ];
}
