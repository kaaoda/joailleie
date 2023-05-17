<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        "full_name",
        "email",
        "phone_number",
        "nationality",
        "balance",
        "notices"
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function dues()
    {
        return $this->morphMany(Due::class, 'dueable');
    }

}
