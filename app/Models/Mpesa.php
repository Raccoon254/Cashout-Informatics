<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_request_id', 'checkout_request_id', 'response_code', 'response_description',
        'customer_message', 'request_id', 'error_code', 'error_message', 'amount',
        'mpesa_receipt_number', 'transaction_date', 'phone_number', 'status'
    ];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
