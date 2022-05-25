<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/get-quantity/{id}', 'ProductController@getQuantity');
Route::get('/search/{q}/{sortBy?}', 'ProductController@searchProducts')->middleware('throttle:60,1');
Route::get('/get-products-from-cart/{cart_id}', 'HomeController@getProductsFromCart');
Route::get('/get-total/{cart_id}', 'HomeController@getTotal')->middleware('throttle:60,1');

Route::post('/add-to-cart', 'ProductController@addToCart');

Route::post('/get-addresses', 'AddressController@index')->middleware('throttle:60,1');
Route::post('/add-new-address', 'AddressController@store')->middleware('throttle:60,1');
Route::post('/show-address', 'AddressController@show')->middleware('throttle:60,1');
Route::post('/edit-address', 'AddressController@update')->middleware('throttle:60,1');
Route::post('/delete-address', 'AddressController@destroy')->middleware('throttle:60,1');

Route::post('/update-cart', 'ProductController@updateCart')->middleware('throttle:60,1');
Route::post('/remove-from-cart', 'ProductController@removeFromCart')->middleware('throttle:60,1');

Route::post('/get-total', 'OrderController@total')->middleware('throttle:60,1');
Route::post('/if-user-have-address', 'OrderController@ifUserHaveAddress')->middleware('throttle:60,1');
Route::post('/get-products-from-cart', 'OrderController@index')->middleware('throttle:60,1');
Route::post('/create-new-order', 'OrderController@create')->middleware('throttle:60,1');

Route::post('/get-orders', 'OrderController@list')->middleware('throttle:60,1');

Route::post('/get-last-productid', 'AdminController@getLastProductID')->middleware('throttle:60,1');
Route::post('/add-new-product', 'AdminController@addNewProduct')->middleware('throttle:60,1');

Route::post('/load-product', 'AdminController@loadProduct')->middleware('throttle:60,1');
Route::post('/edit-product', 'AdminController@editProduct')->middleware('throttle:60,1');
Route::post('/change-order-status', 'AdminController@changeOrderStatus')->middleware('throttle:60,1');


