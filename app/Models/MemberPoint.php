<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MemberPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'points', 'type', 'description', 'expired_at',
    ];

    protected $casts = ['expired_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scope poin yang masih valid (belum expired)
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('type', 'earned')
            ->where('expired_at', '>', now());
    }
}
