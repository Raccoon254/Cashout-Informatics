<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'referral_code',
        'balance',
        'previous',
        'referred_by',
        'tokens',
        'type',
        'status',
        'last_login',
        'contact',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2',
        'tokens' => 'integer',
        'last_login' => 'datetime',
    ];

    /**
     * Get the user's transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the user's referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function referrals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
       //return all users that have this user as their referrer
        return $this->hasMany(User::class, 'referred_by', 'referral_code');
    }

    /**
     * Get the user's referrer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function referrer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        //return the user that referred this user
        return $this->belongsTo(User::class, 'referral_code', 'referred_by');
    }

    public function sent_transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class, 'from'); // assuming 'from' is your sender's foreign key
    }

    public function received_transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class, 'to'); // 'to' is your recipient's foreign key
    }



}
