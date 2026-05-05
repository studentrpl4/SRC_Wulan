<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'min_purchase', 'gift_type', 'promo_id',
        'gift_name', 'gift_description', 'duration_days',
        'start_date', 'end_date', 'is_active',
    ];

    protected $casts = ['start_date' => 'datetime', 'end_date' => 'datetime'];

    public function promo()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function isActive(): bool
    {
        return $this->is_active && now()->between($this->start_date, $this->end_date);
    }
}
