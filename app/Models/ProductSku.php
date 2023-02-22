<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'price', 'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
