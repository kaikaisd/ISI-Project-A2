<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'brand_id',
        'category_id',
        'quantity',
        'isOnSale',
        'isOverSale',
        'isPromotion',
        'promoPrice',
        'isbn',
        'author',
        'publisher',
        'release_date',
        'pages',
    ];
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function productPicture()
    {
        return $this->hasMany(ProductPicture::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

}
