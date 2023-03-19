<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;

class CaDController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('vendor.cad', compact('brands', 'categories'));
    }

    public function addBrand(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->brandName;
        $brand->save();
        return redirect()->back()->with('success', 'Brand added successfully');
    }

    public function addCategory(Request $request)
    {
        $category = new Category();
        $category->name = $request->categoryName;
        $category->save();
        return redirect()->back()->with('success', 'Category added successfully');
    }

    public function deleteBrand(Request $request)
    {
        $brand = Brand::find($request->id);
        $brand->delete();
        return redirect()->back()->with('success', 'Brand deleted successfully');
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
