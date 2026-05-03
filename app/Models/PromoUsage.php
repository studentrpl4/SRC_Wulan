<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'promo_id',
        'order_id',
        'customer_id',
        'discount_amount',
        'used_at',
    ];

    public $timestamps = false;

    public function promo()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }   
}
