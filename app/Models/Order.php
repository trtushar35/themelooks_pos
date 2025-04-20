<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_address',
        'customer_phone',
        'customer_email',
        'payment_method',
        'subtotal',
        'tax',
        'discount',
        'shipping',
        'total',
        'status',
        'notes'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
