<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Product::query();
        $brands = Brand::all();
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->count();
        } else {
            $cart = null;
        }
        $selectedBrand = $request->input('brand','all');
        // Apply brand filter if selected
        if ($request->has('brand')) {
            if ($selectedBrand === 'all') {
                $query->where('id', '>', 0);
            } else {
                $query->where('id', $selectedBrand);
            }
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('price')) {
            if ($request->input('price') === 'asc') {
                $query->orderBy('price', 'asc');
            } else {
                $query->orderBy('price', 'desc');
            }       
        }

        // Sort by price if selected, otherwise default to name
        $sort = $request->input('sort', 'name');
        if ($sort === 'price') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(8);

        return view('index', compact('products', 'sort', 'brands','cart'));
    }
}
