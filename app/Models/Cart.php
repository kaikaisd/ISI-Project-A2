<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    

    public static function itemCount(){
        if (!isset(auth()->user()->id)){
            return 0;
        }
        if (auth()->user()->role !== 1){
            return 0;
        }
        $carts = Cart::where('user_id', auth()->user()->id)->count();
        return $carts;
    }
}
