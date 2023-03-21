<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductPicture;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()){
            return redirect()->route('login');
        }
        $orders = Order::query()->limit(3)->orderByDesc('created_at')->get()->map(function ($order){
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        $newOrders = Order::query()->where('status', 1)->count();
        $processingOrders = Order::query()->where('status', 2)->count();
        $completedOrders = Order::query()->where('status', 3)->count();
        
        $topProducts = OrderProduct::query()->withCount('product')->select('product_id',DB::raw('COUNT(quantity) as sales'))->groupBy('product_id')->orderByDesc('product_id');
        if ($request->route('start_date')){
            $topProducts->whereDate('created_at', '>=', $request->route('start_date'));
        }
        if ($request->route('end_date')){
            $topProducts->whereDate('created_at', '<=', $request->route('end_date'));
        }
        $topProducts = $topProducts->limit(5)->get();
        $topProductsLabel = $topProducts->map(function ($product){
            return $product->product->name;
        });        
        $topProductsData = $topProducts->map(function ($product){
            return $product->sales;
        });

        return view('vendor.index', compact('orders', 'newOrders', 'processingOrders', 'completedOrders', 'topProducts', 'topProductsData', 'topProductsLabel'));
        # return view('user.index');
    }

    public function orderList(Request $request){
        if (!auth()->check()){
            return redirect()->route('login');
        }
        $orders = Order::query()->orderByDesc('created_at');
        if ($request->id){
            $orders = $orders->where('id', $request->id);
        }
        if ($request->user){
            $orders = $orders->where('user_id', $request->user);
        }
        if ($request->date){
            $orders = $orders->whereDate('created_at', $request->date);
        }
        if ($request->status){
            $orders = $orders->where('status', $request->status);
        }
        $orders = $orders->paginate(10);
        $orders->map(function ($order){
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        return view('vendor.order', compact('orders'));
    }
    
    public function orderDetails(Request $request){
        if (!auth()->check()){
            return redirect()->route('login');
        }
        if ($request->route('id')){
            if ($request->route('id') == 'new'){
                $order = new Order();
            }else{
                $order = Order::find($request->route('id'));
                $order->status = Order::statusFormat($order->status);
            }
            return view('vendor.detail', compact('order'));
        }
        return redirect('vendor.order.index');
    }

    public function productList(Request $request){
        if (!auth()->check()){
            return redirect()->route('login');
        }
        $products = Product::query();
        if ($request->sort){
            if ($request->sort == 'id'){
                if ($request->order == 'asc'){
                    $products = $products->orderBy('id');
                }else{
                    $products = $products->orderBy('name');
                }
            }
            if ($request->sort == 'quantity'){
                if ($request->order == 'asc'){
                    $products = $products->orderBy('quantity');
                }else{
                    $products = $products->orderBy('price');
                }
            }
        }
        if ($request->search){
            $products = $products->where('name', 'like', '%'.$request->search.'%')->orWhere('id', 'like', '%'.$request->search.'%');
        }
        $products = $products->paginate(10);
        return view('vendor.product', compact('products'));
    }

    public function productDetails(Request $request){
        if (!auth()->check()){
            return redirect()->route('login');
        }
        if ($request->route('id')){
            if ($request->route('id') == 'new'){
                $product = new Product();
            }else{
                $product = Product::find($request->route('id'));
            }
        }
        $brands = Brand::all();
        $categories = Category::all();
        return view('vendor.edit', compact('product', 'brands', 'categories'));
    }

    public function expressAction(Request $request,Order $order){
        if (!auth()->check()){
            return redirect()->route('login');
        }
        if ($request->route('id')){
            $order = $order->findOrFail($request->route('id'));
            if ($request->route('action') == 'hold'){
                $order->status = 2;
                $order->save();
                return redirect()->route('vendor.order.index', 302)->with(['success' => 'Order held successfully']);
            }
            if ($request->route('action') == 'done'){
                $order->status = 3;
                $order->save();
                return redirect()->route('vendor.order.index', 302)->with(['success' => 'Order shipped successfully']);
            }
            if ($request->route('action') == 'cancel'){
                $order->status = -1;
                $order->save();
                return redirect()->route('vendor.order.index', 302)->with(['success' => 'Order canceled successfully']);
            }
        }
        return redirect()->route('vendor.order.index');
    }


    public function orderStore(Request $request, Order $order){
        if (!auth()->check()){
            return redirect()->route('login');
        }
        if ($request->route('action') == 'delete'){
            $order->find($request->route('id'))->delete();
            return redirect()->route('vendor.order.index', 302)->with(['success' => 'Order deleted successfully']);
        }
        if ($request->route('action') == 'update'){
            $request->validate([
                'status' => 'required',
            ]);
            $order = $order->find($request->route('id'));
            $order->status = $request->status;
            $order->save();
            return redirect()->route('vendor.order.index', 302)->with(['success' => 'Order updated successfully']);
        }
        return redirect()->route('vendor.order.index', 302)->with(['warning' => 'No updated made']);
    }
    
    public function productStore(Request $request, Product $product, ProductPicture $picture){
        if (!auth()->check()){
            return redirect()->route('login');
        }
        if ($request->route('action') == 'deleteImage'){
            $path = $picture->find($request->route('pid'));
            Storage::delete($path);
            $path->delete();
            return redirect()->route('vendor.product.action', ['id' => $request->route('id')])->with(['success' => 'Image deleted successfully']);
        }
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'isbn' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'release_date' => 'required',
            'pages' => 'required',
        ]);


        $product = $product->updateOrCreate(['id' => $request->id], $request->all());
        if ($request->hasFile('new_image')){
            //dd($request->all());
            foreach($request->new_image as $image)
            {
                $path = $image->store('img', 'public');
                //dd($path);
                $result = $picture->updateOrCreate(['product_id' => $product->id, 'path' => 'storage/'.$path]);
            }
        }
        if ($request->continue_edit){
            return redirect()->route('vendor.product.action', ['id' => $product->id,'action' => 'edit'])->with(['success' => 'Add product successfully']);
        }
        return redirect()->route('vendor.product.index')->with(['success' => 'Product saved successfully']);
    }

}
