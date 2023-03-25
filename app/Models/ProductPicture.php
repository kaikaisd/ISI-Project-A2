<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    use HasFactory;

    protected $table = 'product_picture';

    protected $fillable = [
        'id',
        'product_id',
        'path',
        'order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPictureAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function setPictureAttribute($value)
    {
        $this->attributes['path'] = $value->store('products');
    }
    
}
