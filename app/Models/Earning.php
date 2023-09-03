<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from',
        'amount',
        'total_amount',
        'description',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
