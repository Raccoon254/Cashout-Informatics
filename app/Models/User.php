<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the user's referrals.
     *
     * @return HasMany
     */

    public function referrals(): HasMany
    {
       //return all users that have this user as their referrer
        return $this->hasMany(User::class, 'referred_by', 'referral_code');
    }

    /**
     * Get the user's referrer.
     *
     * @return BelongsTo
     */

    public function referrer(): BelongsTo
    {
        //return the user that referred this user
        return $this->belongsTo(User::class, 'referral_code', 'referred_by');
    }

    public function sent_transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'from'); // assuming 'from' is your sender's foreign key
    }

    public function received_transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'to'); // 'to' is your recipient's foreign key
    }

    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function unreadNotificationCount(): int
    {
        $unreadCount = 0;

        // Loop through each notification associated with the user
        $notifications = $this->allNotifications();
        foreach ($notifications as $notification) {
            if (!$notification->isReadByUser($this->id)) {
                $unreadCount++;
            }
        }

        return $unreadCount;
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
    public function unreadNotifications(): \Illuminate\Database\Eloquent\Collection
    {
        return Notification::unreadForUser($this->id)->get();
    }

    public function readNotifications(): \Illuminate\Database\Eloquent\Collection
    {
        return Notification::readForUser($this->id)->get();
    }

    public function allNotifications(): \Illuminate\Database\Eloquent\Collection
    {
        return Notification::allForUser($this->id)->get();
    }

    //get unread notifications
    public function getUnreadNotificationsAttribute(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->unreadNotifications();
    }

}
