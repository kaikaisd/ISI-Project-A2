<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
      
        $product = Product::findOrFail($id);
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        $price = $product->price ?? 0;
        return view('products.show', compact('product'));

    }


}






