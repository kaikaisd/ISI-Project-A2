<?php

namespace App\Observers;

use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Order;

class UpdateOrderWhenRefilled
{

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        if ($product->quantity > 0){
            $orders = Order::where('status', 2)->get();
            // check all orderProduct is enough quantity
            foreach ($orders as $order){
                $orderProduct = OrderProduct::where('order_id', $order->id)->get();
                foreach ($orderProduct as $orderProduct){
                    if ($orderProduct->product->quantity < $orderProduct->quantity){
                        $order->status = 1;
                        $order->save();
                    }
                }
            }

        }
    }

}
