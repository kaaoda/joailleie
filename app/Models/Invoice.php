<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoicable_type",
        "invoicable_id",
        "user_id",
        "invoice_number",
        "date",
        "paid_amount",
        "completed",
        "next_due_date",
        "product_division_id"
    ];

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class, "invoice_id");
    }

    public function dues()
    {
        return $this->morphMany(Due::class, 'dueable');
    }

    public function division()
    {
        return $this->belongsTo(ProductDivision::class, "product_division_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoicable()
    {
        return $this->morphTo();
    }
}
