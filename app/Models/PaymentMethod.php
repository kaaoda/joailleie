<?php

namespace App\Models;

use App\Traits\Deletable;
use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory, Storable, Deletable;

    protected $fillable = [
        "name",
        "image_path"
    ];

    public function invoicePayments()
    {
        return $this->hasMany(InvoicePayment::class);
    }
}
