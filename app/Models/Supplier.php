<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "contact_name",
        "phone_number",
        "balance"
    ];

    public function transactions()
    {
        return $this->hasMany(SupplyTransaction::class, "supplier_id");
    }

    public function dues()
    {
        return $this->morphMany(Due::class, 'dueable');
    }
}