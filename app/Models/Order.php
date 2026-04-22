<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice',
        'address',
        'payment_method',
        'total_price',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function transaksi()
    {
        return $this->hasOne(transaksi::class, 'order_id');
    }

    protected static function booted()
    {
        static::updated(function ($order) {
            if ($order->isDirty('status') && $order->status === 'shipped') {

                $customer = $order->customer;

                if ($customer && $customer->phone) {

                    $phone = preg_replace('/^0/', '62', $customer->phone);

                    $message = "Halo {$customer->name},\nPesanan Anda dengan invoice *{$order->invoice}* sedang *Dikirim*. \nTerima kasih sudah belanja di Madina Shop 🙏";

                    \App\Services\WhatsAppService::send($phone, $message);
                }
            } elseif ($order->isDirty('status') && $order->status === 'completed') {
                $customer = $order->customer;

                if ($customer && $customer->phone) {

                    $phone = preg_replace('/^0/', '62', $customer->phone);

                    $message = "Halo {$customer->name}, 
                    Pesanan Anda dengan invoice *{$order->invoice}* sudah *Diterima*. 
                    Terima kasih sudah belanja di Madina Shop 🙏";

                    \App\Services\WhatsAppService::send($phone, $message);
                }
            }
        });
    }
}
