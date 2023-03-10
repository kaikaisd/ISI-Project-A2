<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Cart;

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

        return view('index', compact('products', 'sort', 'brands','carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function details(Request $request){
        $carts = Cart::itemCount();

        if ($request->route('id')) {
            $product = Product::find($request->route('id'));
            return view('productDetails', compact('product','carts'));
        }

    }
}
