<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Comment;

class UserController extends Controller
{
    public function index()
    {
        if (!isset(auth()->user()->id)){
            return redirect()->route('login');
        }
        $orders = Order::where('user_id', auth()->user()->id)->limit(3)->orderByDesc('created_at')->get();
        return view('user.index', compact('orders'));
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

    public function review(Request $request){
        if ($request->id){
            $order = Order::find($request->id);
            if ($order->user_id != $request->user()->id){
                return redirect()->route('user.index');
            }
            if ($request->isMethod('post')){
                $order->rating = $request->rating;
                $order->review = $request->review;
                $order->save();
                return redirect()->route('user.order');
            }
            return view('user.review', compact('order'));
        }
    }

    public function updatePassword(Request $request){
        if ($request->isMethod('post')){
            $request->validate([
                'password' => 'required|min:6',
                'password_confirmation' => 'required|same:password',
            ]);
            //dd($request->all());
            $user = $request->user();
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('user.index')->with('success', 'Update password successfully');
        }
        return view('user.index')->with('error', 'Update password failed');
    }
}
