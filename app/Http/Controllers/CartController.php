<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function addCart(Request $request){
        $cart = Cart::query()->where('user_id', $request->user()->id)->where('product_id', $request->route('id'))->first();
        if ($cart){
            $result = Cart::where('user_id', $request->user()->id)->where('product_id', $request->id)->update([
                'quantity' => $cart->quantity + 1,
            ]);
        }else{
            $result = Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->id,
                'quantity' => $request->quantity,
            ]);
        }
        if ($result){
            return redirect()->back()->with('success', 'Add to cart successfully');
        }
        return redirect()->back()->with('error', 'Add to cart failed');
    }


    public function form()
    {
        if (!isset(auth()->user()->id)){
            return redirect()->route('home');
        }
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $totalPrice = $carts->sum(function ($carts) {
            return $carts->quantity * $carts->product->price;
        });
        //dd($carts);
        return view('cart.index', compact(['carts', 'totalPrice']));
    }


    public function store(Request $request){
        dd($request->all());
        $newOrder = new Order();
        $newOrder->user_id = $request->user()->id;
        $newOrder->status = 1;
        $result = $newOrder->save();
        if($result){
            foreach ($request->product_id as $key => $value) {
                $newOrderProduct = new OrderProduct();
                $productData = Product::find($value);
                $productData->quantity -= $request->quantity[$key];
                $productData->save();
                $newOrderProduct->order_id = $result->id;
                $newOrderProduct->product_id = $value;
                $newOrderProduct->quantity = $request->quantity[$key];
                $newOrderProduct->price = $request->price[$key];
                $results = $newOrderProduct->save();
            }
            if($results){
                return redirect()->route('cart.result')->with('success', 'Order has been placed successfully');
            }else{
                return redirect()->route('cart.result')->with('error', 'Order has been placed failed');
            }
        }
    }

    public function destory(Request $request){
        //dd($request->all());
        $cart = Cart::query()->where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
        if ($cart){
            $result = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->delete();
        }
        if ($result){
            return redirect()->route('cart.index')->with('success', 'Delete successfully');
        }
        return redirect()->route('cart.index')->with('error', 'Delete failed');
    }

    public function updateCart(Request $request){
        $cart = Cart::query()->where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
        if ($cart){
            $result = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->update([
                'quantity' => $request->quantity,
            ]);
        }
        if ($result){
            return redirect()->route('cart.index')->with('success', 'Update successfully');
        }
        return redirect()->route('cart.index')->with('error','Update failed');
    }
}
