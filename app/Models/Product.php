<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'unit',
        'unit_value',
        'selling_price',
        'purchase_price',
        'discount',
        'tax',
        'image',
        'status'
    ];

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function variation()
    {
        return $this->hasOne(ProductVariation::class);
    }

    public function getImageAttribute($value)
    {
        return (!is_null($value)) ? env('APP_URL') . '/storage/' . $value : null;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
