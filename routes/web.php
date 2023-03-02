<?php

use Illuminate\Support\Facades\Route;

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
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('product.index');
// Route::get('/product/{id}')->name('product.detail');
Route::get('cart', [App\Http\Controllers\ProductsController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [App\Http\Controllers\ProductsController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [App\Http\Controllers\ProductsController::class, 'update'])->name('update.cart');
Route::delete('remove-from-cart', [App\Http\Controllers\ProductsController::class, 'remove'])->name('remove.from.cart');
// Route::group(['prefix'=>'/cart'],function(){
//     Route::get('/','CartController@index')->name('cart.index');
//     Route::post('/add/{id}','CartController@add')->name('cart.add');
//     Route::post('/update/{id}','CartController@update')->name('cart.update');
//     Route::post('/remove/{id}','CartController@remove')->name('cart.remove');
//     Route::post('/clear','CartController@clear')->name('cart.clear');
// })->middleware('auth');

// Route::group(['prefix'=>'/user'],function(){
//     Route::get('/','UserController@index')->name('user.index');
//     Route::get('/order')->name('user.order');
//     Route::get('/order/{id}')->name('user.order.detail');
//     Route::post('/order/{id}/cancel')->name('user.order.cancel');
//     Route::get('/order/{id}/review')->name('user.order.review');
//     Route::post('/order/{id}/review')->name('user.order.review');
// })->middleware('auth');

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
// });