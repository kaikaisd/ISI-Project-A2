<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
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

// Route::group(['prefix'=>'/cart'],function(){
//     Route::get('/','CartController@index')->name('cart.index');
//     Route::post('/add/{id}','CartController@add')->name('cart.add');
//     Route::post('/update/{id}','CartController@update')->name('cart.update');
//     Route::post('/remove/{id}','CartController@remove')->name('cart.remove');
//     Route::post('/clear','CartController@clear')->name('cart.clear');
// })->middleware('auth');

Route::group(['prefix'=>'/cart'], function(){
    Route::get('/',[CartController::class, 'form'])->name('cart.index');
    Route::post('/add/{id}',[CartController::class, 'addCart'])->name('cart.add');
    Route::delete('/destroy',[CartController::class, 'destory'])->name('cart.destroy');
    Route::post('/update',[CartController::class, 'updateCart'])->name('cart.update');
})->middleware('auth');

Route::group(['prefix'=>'/user'],function(){
    Route::get('/',[UserController::class,'index'])->name('user.index');
    Route::post('/change-password',[UserController::class,'updatePassword'])->name('user.change-password');
})->middleware('auth');

Route::group(['prefix' => '/order'],function(){
    Route::post('/new',[OrderController::class, 'store'])->name('order.store');
    Route::get('/result',[OrderController::class, 'result'])->name('order.results');
    Route::get('/',[OrderController::class, 'index'])->name('order.index');
    Route::get('/{id}',[OrderController::class, 'index'])->name('order.detail');
    Route::post('/{id}/cancel',[OrderController::class, 'index'])->name('order.cancel');
    Route::get('/{id}/review',[OrderController::class, 'index'])->name('order.review');
    Route::post('/{id}/review',[OrderController::class, 'index'])->name('order.review');
})->middleware('auth');

Route::group(['prefix'=>'/vendor'],function(){
    Route::get('/',[VendorController::class,'index'])->name('vendor.index');
    Route::get('/order',[VendorController::class,'orderList'])->name('vendor.order');
    Route::get('/order/{id}',[VendorController::class,'orderDetail'])->name('vendor.order.detail');
    Route::post('/order/{id}/accept',[VendorController::class,'orderDetail'])->name('vendor.order.accept');
    Route::post('/order/{id}/update',[VendorController::class,'orderDetail'])->name('vendor.order.update');
    Route::post('/order/{id}/reject',[VendorController::class,'orderDetail'])->name('vendor.order.reject');
    Route::group(['prefix'=>'/product'],function(){
        Route::get('/','VendorController@product')->name('vendor.product');
        Route::get('/create',[VendorController::class,'productCreate'])->name('vendor.product.create');
        Route::post('/create',[VendorController::class,'productStore'])->name('vendor.product.create');
        Route::get('/{id}/edit',[VendorController::class,'productDetail'])->name('vendor.product.edit');
        Route::post('/{id}/edit',[VendorController::class,'productDetail'])->name('vendor.product.edit');
        Route::post('/{id}/delete',[VendorController::class,'productDelete'])->name('vendor.product.delete');
        Route::post('/{id}/upload',[VendorController::class,'productUpload'])->name('vendor.product.upload');
    });
})->middleware('auth');