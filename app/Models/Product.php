<?php

namespace App\Models;

use App\Traits\Deletable;
use App\Traits\Storable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, Storable, Deletable, SoftDeletes;

    protected $fillable = [
        "product_category_id",
        "branch_id",
        "supplier_id",
        "kerat",
        "weight",
        "cost",
        "manufacturing_value",
        "lowest_manufacturing_value_for_sale",
        "thumbnail_path",
        "barcode",
        "quarantined",
        "deleted_at"
    ];

    protected $attributes = [
        "cost" => 0
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, "product_category_id");
    }

    public function division()
    {
        return $this->category->division();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function diamonds()
    {
        return $this->morphMany(Diamond::class, "diamondable");
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    protected function thumbnailPath():Attribute
    {
        return new Attribute(
            get:fn($value) => $value !== NULL ? asset('storage/'.$value) : asset('assets/img/logo.png')
        );
    }

    public function setBarcodeAttribute($value)
    {
        $this->attributes['barcode'] = $value ?? substr($this->category->name,0,1) . rand(1, 9999999) . str_replace([',','.'], "", $this->weight);
    }
}
