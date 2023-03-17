<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carts = Cart::itemCount();
        $sort = $request->query('sort', 'created_at');
        $order = $request->query('order', 'asc');
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->orderBy($sort, $order)->get();
        $orders->map(function ($order) {
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        return view('order.index', compact('orders', 'sort', 'order','carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!isset(auth()->user()->id)) {
            return redirect()->route('index');
        }
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $totalPrice = $carts->sum(function ($carts) {
            if ($carts->product->isPromotion == 1){
                return $carts->quantity * $carts->product->promotion_price;
            }else{
                return $carts->quantity * $carts->product->price;
            }
        });
        $_GLOBAL['flag'] = 0;

        foreach($carts as $item){
            if ($item->product->isOnSale == 0)
            {
                return redirect()->route('cart.index')->with('error', 'The product you are trying to buy is out of stock and can not be purchased.');
            }
            if($item->product->quantity < $item->quantity){
                $_GLOBAL['flag'] = 1;
            }
        }

        $newOrder = new Order();
        $newOrder->user_id = $request->user()->id;
        $newOrder->price = $totalPrice;
        $newOrder->status = ($_GLOBAL['flag'] == 1 ? 2 : 1);
        $result = $newOrder->save();
        if ($result) {
            foreach ($carts as $key => $value) {
                $newOrderProduct = new OrderProduct();
                $productData = Product::find($value->product_id);
                $productData->quantity -= $value->quantity;
                $productData->save();
                $newOrderProduct->order_id = $newOrder->id;
                $newOrderProduct->product_id = $value->product_id;
                $newOrderProduct->quantity = $value->quantity;
                $newOrderProduct->price = ($value->product->isPromotion == 1 ? $value->product->promoPrice : $value->product->price );
                $results = $newOrderProduct->save(); 
            }
            if ($results) {
                $result = 'success';
                $orderId = $newOrder->id;
                Cart::where('user_id', auth()->user()->id)->delete();
                return redirect()->route('order.results', compact('orderId', 'result'))->with('success', 'Order has been placed successfully');
            } else {
                return redirect()->route('order.results', compact('results'))->with('message', 'Order has been placed failed');
            }
        }
    }

    public function result(Request $request)
    {
        $carts = Cart::itemCount();
        if (!isset(auth()->user()->id)) {
            return redirect()->route('index');
        }
        if ($request->result) {
            $result = $request->result;
            $orderId = $request->orderId;
            return view('order.result', compact('orderId', 'carts', 'result'));
        }
        return view('order.result');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, Order $order)
    {
        if (!isset(auth()->user()->id)) {
            return redirect()->route('index');
        }
        $order = Order::find($request->route('id'));
        $order->status = -1;
        $order->save();
        return redirect()->route('order.index')->with('success', 'Order has been cancelled successfully');
    }

    public function detail(Request $request, Order $order){
        $carts = Cart::itemCount();
        $order = Order::find($request->route('id'));
        $order->status = Order::statusFormat($order->status);

        return view('order.detail', compact('order', 'carts'));
    }
}
