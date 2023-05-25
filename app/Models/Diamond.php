<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diamond extends Model
{
    use HasFactory;

    protected $fillable = [
        "diamondable_type",
        "diamondable_id",
        "number_of_stones",
        "weight",
        "clarity",
        "color",
        "shape",
        "price",
        "currency_id",
        "exchange_rate"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
