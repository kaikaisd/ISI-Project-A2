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
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/product')->name('product');
// Route::get('/product/{id}')->name('product.detail');

// Route::group(['prefix'=>'/cart'],function(){
//     Route::get('/','CartController@index')->name('cart.index');
//     Route::post('/add/{id}','CartController@add')->name('cart.add');
//     Route::post('/update/{id}','CartController@update')->name('cart.update');
//     Route::post('/remove/{id}','CartController@remove')->name('cart.remove');
//     Route::post('/clear','CartController@clear')->name('cart.clear');
// })->middleware('auth');

Route::group(['prefix'=>'/vendor'],function(){

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
 });
