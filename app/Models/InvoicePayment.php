<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "invoice_id",
        "payment_method_id",
        "value",
        "percent",
        "currency_id",
        "rate"
    ];

    public function PaymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
