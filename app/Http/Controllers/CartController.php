<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->input('porduct_id'));
        if (Cart::get($product->id)){
            Cart::update ($product->id, [
                'quantity' => Cart::get($product->id)['quantity'] + 1
            ]);
        } else {
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => [
                    'image' => $product->image
                    'description' => $product->description,
                ]
            ]);
        }
        return redirect()->route('cart.index');
    }
}
