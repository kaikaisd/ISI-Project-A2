<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Comment;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $carts = Cart::itemCount();
        if (!isset(auth()->user()->id)){
            return redirect()->route('login');
        }
        $orders = Order::where('user_id', auth()->user()->id)->limit(3)->orderByDesc('created_at')->get()->map(function ($order){
            // $order->total = $order->orderProducts->sum(function ($orderProduct){
            //     return $orderProduct->quantity * $orderProduct->product->price;
            // });
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        return view('user.index', compact('orders', 'carts'));
        # return view('user.index');
    }

    public function order(Request $request)
    {
        if ($request->id){
            $order = Order::find($request->id);
            if ($order->user_id != $request->user()->id){
                return redirect()->route('user.order');
            }
            return view('user.order', compact('order'));
        }
        return view('user.order');
    }

    public function cancel(Request $request){
        if ($request->id){
            $order = Order::find($request->id);
            if ($order->user_id != $request->user()->id){
                return redirect()->route('user.order');
            }
            $order->status = -1;
            $order->save();
            return redirect()->route('user.order');
        }
        return redirect()->route('user.order');
    }

    public function updatePassword(Request $request){
        if ($request->isMethod('post')){
            $request->validate([
                'password' => 'required|min:6|regex:/[A-Z]/|regex:/[0-9]/',
                'password_confirmation' => 'required|same:password',
            ]);
            //dd($request->all());
            $user = $request->user();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('user.index')->with('success', 'Update password successfully');
        }
        return view('user.index')->with('error', 'Update password failed');
    }
}
