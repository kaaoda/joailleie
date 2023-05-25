<?php

namespace App\Models;

use App\Traits\Deletable;
use App\Traits\Storable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory, Storable, Deletable;

    protected $fillable = [
        "full_name",
        "phone_number",
        "job_title",
        "branch_id"
    ];

    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
