<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

     protected $fillable = [
                    'name', 'description', 'price', 'quantity',
                    'pic', 'category_id', 'brand_id', 'isOnSale',
                    'isOverSale', 'isPromotion', 'promoPrice', 'category', 'brand'
    ];
    protected $casts = [
        'isOnSale' => 'boolean', // on_sale 是一个布尔类型的字段
        'isOverSale' => 'boolean',
        'isPromotion' => 'boolean',

    ];
    // 与商品SKU关联
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
