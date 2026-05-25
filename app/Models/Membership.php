<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'member_points';

    protected $fillable = [
        'user_id', 'payment_order_id', 'ktp_photo',
        'status', 'approved_at', 'approved_by', 'rejection_reason',
    ];

    protected $casts = ['approved_at' => 'datetime'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function paymentOrder()
    {
        return $this->belongsTo(Order::class, 'payment_order_id');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
