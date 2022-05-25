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

Route::get('/', 'HomeController@index');
Route::view('/kontakt', 'contact');

Route::get('/p/{name}', 'ProductController@index');

Route::get('/wyszukaj', 'ProductController@search')->name('search');

Route::get('/katalog', 'HomeController@catalog');
Route::get('/koszyk', 'HomeController@cart');
Route::get('/zamowienie', 'HomeController@beforeOrder');

Route::post('/zamowienie', 'HomeController@order')->name('go-to-order');

Route::get('/konto', 'AccountController@index');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/', 'AdminController@index');
    Route::view('/produkt/nowy', 'new-product');
    Route::get('/koszyki', 'AdminController@carts');
    Route::get('/koszyki/{id}', 'AdminController@cart');
    Route::post('/koszyk/usun', 'AdminController@deleteCart')->name('deleteCart');
    Route::get('/zamowienia', 'AdminController@orders');
    Route::get('/zamowienia/{id}', 'AdminController@order');
    Route::post('/zamowienie/delete', 'AdminController@deleteOrder')->name('deleteOrder');
    Route::get('/produkty', 'AdminController@products');
    Route::get('/produkty/{id}', 'AdminController@product');
    Route::post('/produkty/delete', 'AdminController@deleteProduct')->name('deleteProduct');
});

Route::get('/adresy', 'AccountController@addresses');

Route::post('/zaloguj', 'HomeController@authenticateBeforeOrder')->name('order-login');
Route::post('/wyloguj', 'AccountController@logout')->name('logout-user');

// Auth Routes

Auth::routes();

Route::view('/logowanie', 'auth.login');
Route::view('/rejestracja', 'auth.register');
Route::view('/resetowanie', 'auth.passwords.email');
