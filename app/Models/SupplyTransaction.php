<?php

namespace App\Models;

use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyTransaction extends Model
{
    use HasFactory, Storable;

    protected $fillable = [
        "supplier_id",
        "product_division_id",
        "ore_weight_in_grams",
        "cost_per_gram",
        "cost_type",
        "currency_id",
        "paid_amount",
        "date",
        "transaction_scope",
        "products_number",
        "notices"
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function division()
    {
        return $this->belongsTo(ProductDivision::class, "product_division_id");
    }

    public function dues()
    {
        return $this->morphMany(Due::class, "dueable");
    }
}
