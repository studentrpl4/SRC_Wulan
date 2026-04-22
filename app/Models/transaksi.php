<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'order_id',
        'status',
        'snap_token',
        // 'product_id', di video itu brand_id
    ];
}
