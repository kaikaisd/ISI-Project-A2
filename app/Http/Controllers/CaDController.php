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
        if ($request->brandName == ""){
            return redirect()->back()->with('error', 'Brand name cannot be empty');
        }
        if (Brand::where('name', $request->brandName)->exists()){
            return redirect()->back()->with('error', 'Brand already exists');
        }
        $brand = new Brand();
        $brand->name = $request->brandName;
        $brand->save();
        return redirect()->back()->with('success', 'Brand added successfully');
    }

    public function addCategory(Request $request)
    {
        if ($request->categoryName == ""){
            return redirect()->back()->with('error', 'Category name cannot be empty');
        }
        if (Category::where('name', $request->categoryName)->exists()){
            return redirect()->back()->with('error', 'Category already exists');
        }
        $category = new Category();
        $category->name = $request->categoryName;
        $category->save();
        return redirect()->back()->with('success', 'Category added successfully');
    }

    public function deleteBrand(Request $request)
    {
        $brand = Brand::find($request->id);
        if ($brand->products->count() > 0){
            return redirect()->back()->with('error', 'Brand cannot be deleted because it has products');
        }
        $brand->delete();
        return redirect()->back()->with('success', 'Brand deleted successfully');
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);
        if ($category->products->count() > 0){
            return redirect()->back()->with('error', 'Category cannot be deleted because it has products');
        }
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
