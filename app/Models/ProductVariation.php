<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'color',
        'variation_type',
        'variation_value',
        'purchase_price',
        'selling_price',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
