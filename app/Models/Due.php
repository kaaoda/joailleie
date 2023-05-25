<?php

namespace App\Models;

use App\Events\DueCreated;
use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Due extends Model
{
    use HasFactory, Storable, Notifiable;

    protected $fillable = [
        "dueable_type",
        "dueable_id",
        "paid_amount",
        "paid_at",
        "notices"
    ];

    public function dueable()
    {
        return $this->morphTo();
    }

}
