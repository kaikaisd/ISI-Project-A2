<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Comment;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->check() && $request->user()->role !== 1){
            return redirect()->route('vendor.index');
        }
        $query = Product::query();
        $brands = Brand::all();
        $carts = Cart::itemCount();
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $selectedBrand = $request->input('brand','all');
        // Apply brand filter if selected
        if ($request->has('brand')) {
            if ($selectedBrand === 'all') {
                $query->where('brand_id', '>', 0);
            } else {
                $query->where('brand_id', '=', $selectedBrand);
            }
        }

        
        $price = $request->input('price','asc');
        if ($request->has('price')) {
            if ($price === 'asc') {
                $query->orderBy('price', 'asc');
            } else {
                $query->orderBy('price', 'desc');
            }       
        }


        $products = $query->paginate(10);

        return view('index', compact('products', 'brands','carts'));
    }

    public function details(Request $request){
        $carts = Cart::itemCount();
        $review = Comment::where('product_id', $request->route('id'))->limit(3)->get();
        $avgRating = Comment::where('product_id', $request->route('id'))->avg('rating');
        if ($request->route('id')) {
            $product = Product::find($request->route('id'));
            
            return view('productDetails', compact('product','carts','review', 'avgRating'));
        }

        return redirect()->route('index');
    }
}
