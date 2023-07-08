<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ad_type',
        'content',
        'tokens',
        'views',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
        'tokens' => 'integer',
        'views' => 'integer',
    ];
}
