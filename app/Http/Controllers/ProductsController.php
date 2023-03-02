<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = '';
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
      $product = Product::with(['brand', 'catrgory', 'order'])->find($id);
      return view('products.show', compact('product'));}
}


