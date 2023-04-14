<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Comment;
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
        $order = $request->query('order', 'desc');
        $user = auth()->user();
        $activeOrders = Order::where('user_id', $user->id)->whereIn('status',[1,2])->orderBy($sort, $order)->get();
        $inactiveOrders = Order::where('user_id', $user->id)->whereNotIn('status',[1,2])->orderBy($sort, $order)->get();
        $activeOrders->map(function ($order) {
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        $inactiveOrders->map(function ($order) {
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        return view('order.index', compact('inactiveOrders', 'activeOrders', 'sort', 'order','carts'));
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
        $totalPrice = 0;
        $_GLOBAL['flag'] = 0;

        if ($carts->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        foreach($carts as $item){
            if ($item->product->isOnSale == 0)
            {
                return redirect()->route('cart.index')->with('error', 'The product you are trying to buy is out of stock and can not be purchased.');
            }
            if($item->product->quantity < $item->quantity){
                $_GLOBAL['flag'] = 1;
            }
            if ($item->product->isPromotion == 1){
                $totalPrice += ($item->product->promoPrice * $item->quantity);
            }else{
                $totalPrice += ($item->product->price * $item->quantity);
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
        if (auth()->user()->id != $order->user_id){
            return redirect()->back()->with('error', 'You are not allowed to cancel this order');
        }
        $order->status = -1;
        $order->updater = 0;
        $order->save();
        return redirect()->back()->with('success', 'Order has been cancelled successfully');
    }

    public function detail(Request $request, Order $order){
        $carts = Cart::itemCount();
        // Get order detail and group by product id on order_product table
        $order = Order::with('orderProduct.product')->where('id',$request->route('id'))->get();
        $order = $order[0];
        $order->status = Order::statusFormat($order->status);

        return view('order.detail', compact('order', 'carts'));
    }

    public function review(Request $request, Order $order, OrderProduct $orderProduct){
        $carts = Cart::itemCount();
        $order = Order::find($request->route('id'));
        if (auth()->user()->id != $order->user_id){
            return redirect()->back()->with('error', 'You are not allowed to review this product');
        }
        if ($order->status != 3){
            return redirect()->back()->with('error', 'You are not allowed to review this product');
        }
        $orderProduct = OrderProduct::where('order_id','=',$request->id)->groupBy('product_id')->get();
        if ($orderProduct->count() == 0){
            return redirect()->back()->with('error', 'You are not allowed to review this product');
        }
        $reviews = Comment::where('order_id', $order->id)->get()->keyBy('product_id');

        return view('order.review', compact('order', 'orderProduct', 'carts', 'reviews'));
    }

    public function reviewStore(Request $request, Order $order, OrderProduct $orderProduct, Comment $comment){
        if (!isset(auth()->user()->id)) {
            return redirect()->route('index');
        }
        if ($request->rating == null){
            return redirect()->route('order.review', $request->order_id)->with('error', 'Please rate the product');
        }
        if ($request->reviews == null){
            return redirect()->route('order.review', $request->order_id)->with('error', 'Please write a review');
        }
        $orderProduct = OrderProduct::where('order_id','=',$request->order_id);
        if ($orderProduct->count() == 0){
            return redirect()->route('order.review', $request->order_id)->with('error', 'You are not allowed to review this product');
        }
        foreach($request->product_id as $value){
            $comment = (Comment::where('product_id','=',$value)->firstOrFail() ?? new Comment());
            $comment->user_id = auth()->user()->id;
            $comment->order_id = $request->order_id;
            $comment->product_id = $value;
            $comment->rating = $request->rating[$value] ?? 5;
            $comment->reviews = $request->reviews[$value] ?? '';
            $comment->save();
        }
        return redirect()->route('order.index')->with('success', 'Review has been submitted successfully');
    }
}
