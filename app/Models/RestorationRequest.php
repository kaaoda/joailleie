<?php

namespace App\Models;

use App\Traits\Deletable;
use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestorationRequest extends Model
{
    use HasFactory, Storable, Deletable;

    protected $fillable = [
        'request_number',
        'customer_id',
        'weight',
        'kerat',
        'notices',
        'cost',
        'deposit',
        'status',
        'picture_path'
    ];

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(RestorationRequestTransaction::class);
    }

    public function lastTransaction()
    {
        return $this->transactions()->one()->latestOfMany();
    }
}
