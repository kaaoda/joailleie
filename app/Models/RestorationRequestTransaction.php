<?php

namespace App\Models;

use App\Traits\Deletable;
use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestorationRequestTransaction extends Model
{
    use HasFactory, Storable, Deletable;

    protected $fillable = [
        'restoration_request_id',
        'employee_name',
        'description',
        'happened_at'
    ];

    public function restorationRequest():BelongsTo
    {
        return $this->belongsTo(RestorationRequest::class, "restoration_request_id");
    }
}
