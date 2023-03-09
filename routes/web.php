<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
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
Route::get('/product/{id}', [])->name('product.detail');

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
    Route::post('/order/new',[CartController::class, 'store'])->name('cart.store');
    Route::delete('/destroy',[CartController::class, 'destory'])->name('cart.destroy');
    Route::post('/update',[CartController::class, 'updateCart'])->name('cart.update');
})->middleware('auth');

Route::group(['prefix'=>'/user'],function(){
    Route::get('/',[UserController::class,'index'])->name('user.index');
    Route::post('/change-password',[UserController::class,'updatePassword'])->name('user.change-password');
})->middleware('auth');

Route::group(['prefix' => '/order'],function(){
    Route::get('/')->name('order.index');
    Route::get('/{id}')->name('order.detail');
    Route::post('/{id}/cancel')->name('order.cancel');
    Route::get('/{id}/review')->name('order.review');
    Route::post('/{id}/review')->name('order.review');
})->middleware('auth');

// Route::group(['prefix'=>'/vendor'],function(){
//     Route::get('/','VendorController@index')->name('vendor.index');
//     Route::get('/order')->name('vendor.order');
//     Route::get('/order/{id}')->name('vendor.order.detail');
//     Route::post('/order/{id}/accept')->name('vendor.order.accept');
//     Route::post('/order/{id}/update')->name('vendor.order.update');
//     Route::post('/order/{id}/reject')->name('vendor.order.reject');
//     Route::group(['prefix'=>'/product'],function(){
//         Route::get('/','VendorController@product')->name('vendor.product');
//         Route::get('/create')->name('vendor.product.create');
//         Route::post('/create')->name('vendor.product.create');
//         Route::get('/{id}/edit')->name('vendor.product.edit');
//         Route::post('/{id}/edit')->name('vendor.product.edit');
//         Route::post('/{id}/delete')->name('vendor.product.delete');
//         Route::post('/{id}/upload')->name('vendor.product.upload');
//     });
// })->middleware('auth');