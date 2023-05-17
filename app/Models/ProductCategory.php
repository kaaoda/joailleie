<?php

namespace App\Models;

use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, Storable;

    protected $fillable = [
        "product_division_id",
        "name"
    ];

    public function division()
    {
        return $this->belongsTo(ProductDivision::class, foreignKey: "product_division_id");
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
