<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CaDController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('index');
});

Auth::routes();

Route::get('/home', function (){
    if (auth()->user()->role == 2)
        return redirect('vendor');
    return redirect('index');
})->name('home');
Route::get('/index', [ProductController::class, 'index'])->name('index');
Route::get('/product', function(){
    return redirect('index');
})->name('product');
Route::get('/product/{id}', [ProductController::class,'details'])->name('product.detail');

Route::group(['prefix'=>'/cart'], function(){
    if (auth()->check() && auth()->user()->role == 2){
        return redirect('vendor');
    }
    Route::get('/',[CartController::class, 'form'])->name('cart.index');
    Route::post('/add/{id}',[CartController::class, 'addCart'])->name('cart.add');
    Route::delete('/destroy',[CartController::class, 'destory'])->name('cart.destroy');
    Route::post('/update',[CartController::class, 'updateCart'])->name('cart.update');
})->middleware('auth');

Route::group(['prefix'=>'/user'],function(){
    if (auth()->check() && auth()->user()->role == 2){
        return redirect('vendor');
    }
    Route::get('/',[UserController::class,'index'])->name('user.index');
    Route::post('/change-password',[UserController::class,'updatePassword'])->name('user.change-password');
})->middleware('auth');

Route::group(['prefix' => '/order'],function(){
    if (auth()->check() && auth()->user()->role == 2){
        return redirect('vendor');
    }
    Route::post('/new',[OrderController::class, 'store'])->name('order.store');
    Route::get('/result',[OrderController::class, 'result'])->name('order.results');
    Route::get('/',[OrderController::class, 'index'])->name('order.index');
    Route::get('/{id}',[OrderController::class, 'detail'])->name('order.detail');
    Route::get('/{id}/cancel',[OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('/{id}/review',[OrderController::class, 'review'])->name('order.review');
    Route::post('/{id}/review',[OrderController::class, 'reviewStore'])->name('review.store');
})->middleware('auth');

Route::group(['prefix'=>'/vendor'],function(){
    Route::get('/',[VendorController::class,'index'])->name('vendor.index');
    Route::get('/order',[VendorController::class,'orderList'])->name('vendor.order.index');
    Route::get('/order/{id}',[VendorController::class,'orderDetails'])->name('vendor.order.detail');
    Route::get('/order/{id}/{action?}',[VendorController::class,'expressAction'])->name('vendor.order.action');
    Route::post('/order/{id}/{action?}',[VendorController::class,'orderStore'])->name('vendor.order.action');
    Route::group(['prefix'=>'/product'],function(){
        Route::get('/',[VendorController::class,'productList'])->name('vendor.product.index');
        Route::get('/{id}',[VendorController::class,'productDetails'])->name('vendor.product.action');
        Route::get('/{id}/{action?}',[VendorController::class,'productDetails'])->name('vendor.product.action');
        Route::get('/{id}/{action?}/{pid?}',[VendorController::class,'productStore'])->name('vendor.product.action');
        Route::post('/{id}/{action?}/{pid?}',[VendorController::class,'productStore'])->name('vendor.product.action');
    })->middleware('auth');
    Route::get('/cad',[CaDController::class,'index'])->name('vendor.cad.index');
    Route::post('/cad/brand',[CaDController::class,'addBrand'])->name('vendor.cad.brand.add');
    Route::post('/cad/category',[CaDController::class,'addCategory'])->name('vendor.cad.category.add');
    Route::delete('/cad/brand',[CaDController::class,'deleteBrand'])->name('vendor.cad.brand.delete');
    Route::delete('/cad/category',[CaDController::class,'deleteCategory'])->name('vendor.cad.category.delete');
})->middleware('auth');