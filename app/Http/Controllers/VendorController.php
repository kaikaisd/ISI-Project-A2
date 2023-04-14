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
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        $orders = Order::query()->limit(3)->orderByDesc('created_at')->get()->map(function ($order) {
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        $newOrders = Order::query()->where('status', 1)->count();
        $processingOrders = Order::query()->where('status', 2)->count();
        $completedOrders = Order::query()->where('status', 3)->count();

        $topProducts = OrderProduct::query()->withCount('product')->select('product_id', DB::raw('COUNT(quantity) as sales'), DB::raw('SUM(price) as price'))->groupBy('product_id')->orderByDesc('product_id');
        if ($request->has('start_date') && $request->input('start_date') != '') {
            $topProducts->whereDate('created_at', '>=', $request->input('start_date'));
        }
        if ($request->has('end_date') && $request->input('end_date') != '') {
            $topProducts->whereDate('created_at', '<=', $request->input('end_date'));
        }
        $topProducts = $topProducts->limit(5)->get();
        $topProductsLabel = $topProducts->map(function ($product) {
            return $product->product->name;
        });
        $topProductsData = $topProducts->map(function ($product) {
            return $product->sales;
        });
        $topProductsAmount = $topProducts->map(function ($product) {
            return $product->price;
        });

        return view('vendor.index', compact('orders', 'newOrders', 'processingOrders', 'completedOrders', 'topProducts', 'topProductsData', 'topProductsLabel', 'topProductsAmount'));
        # return view('user.index');
    }

    public function orderList(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        $orders = Order::query();
        if ($request->id && $request->id != '') {
            $orders = $orders->where('id', $request->id);
        }
        if ($request->user && $request->user != '') {
            $orders = $orders->where('user_id', $request->user);
        }
        if ($request->date && $request->date != '') {
            $orders = $orders->whereDate('created_at', $request->date);
        }
        if ($request->status && $request->status != '') {
            $orders = $orders->where('status', $request->status);
        }
        if ($request->sort && $request->sort != '' && $request->order && $request->order != '' && in_array($request->sort,['id','price','created_at', 'updated_at','status']) ) {
            $orders = $orders->orderBy($request->sort, $request->order);
        }else{
            $orders = $orders->orderBy('created_at', 'desc');
        }
        $orders = $orders->paginate(10);
        $orders->map(function ($order) {
            $order->status = Order::statusFormat($order->status);
            return $order;
        });
        return view('vendor.order', compact('orders'));
    }

    public function orderDetails(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        if ($request->route('id')) {
            if ($request->route('id') == 'new') {
                $order = new Order();
            } else {
                $order = Order::find($request->route('id'));
                $order->status = Order::statusFormat($order->status);
            }
            return view('vendor.detail', compact('order'));
        }
        return redirect('vendor.order.index');
    }

    public function productList(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        $query = Product::query();
        $brands = Brand::all();
        if ($request->has('search')) {
            if ($request->input('search') == '') {
                $query->where('id', '>', 0);
            }else{
                $query->where('name', 'like', '%' . $request->input('search') . '%')->orWhere('id', 'like', '%' . $request->input('search') . '%');
            }
            
        }

        $selectedBrand = $request->input('brand', 'all');
        // Apply brand filter if selected
        if ($request->has('brand')) {
            if ($selectedBrand == 'all') {
                $query->where('brand_id', '>', 0);
            } else {
                
                $query->where('brand_id', $selectedBrand);
            }
        }


        $price = $request->input('price', 'asc');
        if ($request->has('price')) {
            if ($price === 'asc') {
                $query->orderBy('price', 'asc');
            } else {
                $query->orderBy('price', 'desc');
            }
        }
        $products = $query->paginate(10);
        return view('vendor.product', compact('products', 'brands'));
    }

    public function productDetails(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        if ($request->route('id')) {
            if ($request->route('id') == 'new') {
                $product = new Product();
            } else {
                $product = Product::find($request->route('id'));
            }
        }
        $brands = Brand::all();
        $categories = Category::all();
        return view('vendor.edit', compact('product', 'brands', 'categories'));
    }

    public function expressAction(Request $request, Order $order)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        if ($request->route('id')) {
            $order = $order->findOrFail($request->route('id'));
            if ($order->status == 3 || $order->status == -1) {
                return redirect()->back()->with(['warning' => 'Order already completed or canceled']);
            }
            if ($request->route('action') == 'hold') {
                if ($order->status == 2) {
                    return redirect()->back()->with(['error' => 'Order already held']);
                }
                $order->status = 2;
                $order->updater = 1;
                $order->save();
                return redirect()->back()->with(['success' => 'Order held successfully']);
            }
            if ($request->route('action') == 'unhold') {
                if ($order->status == 1) {
                    return redirect()->back()->with(['warning' => 'Order already unheld']);
                }
                $order->status = 1;
                $order->updater = 1;
                $order->save();
                return redirect()->back()->with(['success' => 'Order unheld successfully']);
            }
            if ($request->route('action') == 'done') {
                if ($order->status == 3) {
                    return redirect()->back()->with(['warning' => 'Order already shipped']);
                }
                $order->status = 3;
                $order->updater = 1;
                $order->save();
                return redirect()->back()->with(['success' => 'Order shipped successfully']);
            }
            if ($request->route('action') == 'cancel') {
                if ($order->status == -1) {
                    return redirect()->back()->with(['warning' => 'Order already canceled']);
                }
                $order->status = -1;
                $order->updater = 1;
                $order->save();
                return redirect()->back()->with(['success' => 'Order canceled successfully']);
            }
        }
        return redirect()->route('vendor.order.index');
    }


    public function orderStore(Request $request, Order $order)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        if ($request->route('action') == 'delete') {
            $order->find($request->route('id'))->delete();
            return redirect()->route('vendor.order.index', 302)->with(['success' => 'Order deleted successfully']);
        }
        if ($request->route('action') == 'update') {
            $request->validate([
                'status' => 'required',
            ]);
            $order = $order->find($request->route('id'));
            $order->status = $request->status;
            $order->updater = 1;
            $order->save();
            return redirect()->route('vendor.order.index', 302)->with(['success' => 'Order updated successfully']);
        }
        return redirect()->route('vendor.order.index', 302)->with(['warning' => 'No updated made']);
    }

    public function productStore(Request $request, Product $product, ProductPicture $picture)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != 2){
            return redirect()->route('home');
        }
        if ($request->route('action') == 'deleteImage') {
            $path = $picture->find($request->route('pid'));
            Storage::delete($path);
            $path->delete();
            return redirect()->route('vendor.product.action', ['id' => $request->route('id')])->with(['success' => 'Image deleted successfully']);
        }
        if ($request->route('action') == 'delete') {
            $product->find($request->route('id'))->delete();
            return redirect()->route('vendor.product.index', 302)->with(['success' => 'Product deleted successfully']);
        }
        if ($request->id != 'new') {
            if ($product->find($request->route('id'))->quantity < 0 && $request->quantity > 0) {
                $request->merge(['quantity' => ($request->quantity + $product->find($request->route('id'))->quantity)]);
            }
        }
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'brand_id' => 'required',
            'category_id' => 'required',
            'description' => 'required|min:1|max:1000',
            'isbn' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'release_date' => 'required|date|before:tomorrow|after:1900-01-01',
            'pages' => 'required|numeric',
        ]);

        $product = $product->updateOrCreate(['id' => $request->id], $request->all());
        if ($request->id != 'new') {
            if ($request->hasFile('new_image')) {
                //dd($request->all());
                foreach ($request->new_image as $image) {
                    $path = $image->store('img', 'public');
                    //dd($path);
                    $result = $picture->updateOrCreate(['product_id' => $product->id, 'path' => 'storage/' . $path]);
                }
            } else {
                //dd($request->all());
                if ($request->image_order) {
                    foreach ($request->image_order as $key => $order) {
                        //dd($key, $order);
                        $result = $picture->where('id', $key)->update(['order' => $order]);
                    }
                }
            }
        }
        if ($request->continue_edit) {
            if ($request->id == 'new'){
            return redirect()->route('vendor.product.action', ['id' => $product->id, 'action' => 'edit'])->with(['success' => 'Add product successfully']);
            } else{
                return redirect()->route('vendor.product.action', ['id' => $product->id, 'action' => 'edit'])->with(['success' => 'Product updated successfully']);
            }
        }
        return redirect()->route('vendor.product.index')->with(['success' => 'Product saved successfully']);
    }
}
