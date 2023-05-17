<?php

namespace App\Models;

use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Storable;

    protected $fillable = [
        "order_number",
        "customer_id",
        "branch_id",
        "total",
        "date"
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withPivot(["price", "gram_price", "sale_manufacturing_value", "quantity"]);
    }

    public function additionalServices()
    {
        return $this->hasMany(OrderAdditionalService::class);
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, "invoicable");
    }
}
