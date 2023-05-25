<?php

namespace App\Models;

use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    use HasFactory, Storable;

    protected $fillable = [
        'order_id',
        'diff_amount',
        'total',
        'total_weight',
        'type'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['price']);
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, "invoicable");
    }

}
