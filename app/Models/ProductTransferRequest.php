<?php

namespace App\Models;

use App\Traits\Deletable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransferRequest extends Model
{
    use HasFactory, Deletable;

    protected $fillable = [
        "branch_id",
        "approved",
        "notices"
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
