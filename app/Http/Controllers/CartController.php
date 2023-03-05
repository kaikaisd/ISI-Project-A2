<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
class CartController extends Controller
{
    public function index()
    {
        
        $cartItems = Cart::with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

     public function update($id)
    {
        $quantity = request()->input('quantity', 1);
        $cart = json_decode(request()->cookie('cart', '{}' ), true);
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        return response()
        ->json(['cartCount' => array_sum($cart)])
        ->cookie('cart', json_encode($cart));
    }

    public function add($id)
    {
        $products = Product::findOrFail($id);

        Cart::add([
            'id' => $products->id,
            'name' => $products->name,
            'price' => $products->price,
            'quantity' => 1,
            'attributes' => [
            'image' => $products->image
            ]
        ]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }

    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
    }


}
