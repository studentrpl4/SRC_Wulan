<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';

    protected $fillable = [
        'email',
        'password',
        'name',
        'phone',
        'gender',
        'birth_date',
        'profile_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'profile_completed' => 'boolean',
        'birth_date' => 'date',
    ];

    // mutator agar password otomatis di-hash
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }

    /**
     * Get the chat messages for the customer.
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Get the membership application for the customer.
     */
    public function membership()
    {
        return $this->hasOne(Membership::class, 'user_id');
    }

    /**
     * Get the points transactions for the customer.
     */
    public function points()
    {
        return $this->hasMany(MemberPoint::class, 'user_id');
    }

    /**
     * Check if customer is an active member.
     */
    public function isMember(): bool
    {
        return $this->membership?->status === 'active';
    }

    /**
     * Calculate available points for the customer.
     */
    public function availablePoints(): int
    {
        return $this->points()
            ->where('expired_at', '>', now())
            ->whereIn('type', ['earned'])
            ->sum('points')
            + $this->points()->whereIn('type', ['redeemed', 'voided', 'expired'])->sum('points');
    }
}
