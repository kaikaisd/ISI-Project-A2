<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {//display products id products
        $products = 'products';
        return view('products.index', compact('products'));
    }

  /*  public function show($id)
    {
      $product = Product::with(['brand', 'category', 'order'])->find($id);
      return view('products.show', compact('product'));}*/

      public function cart()
      {
          return view('cart');
      }

      public function addToCart($id)
    {
        $product = Product::findOrFail($id);
          
        $cart = session()->get('cart', []);
  
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
          
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
}


