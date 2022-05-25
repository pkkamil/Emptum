<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Cookie;
use App\CartPart;

class HomeController extends Controller
{
    public function index() {
        $products = Product::paginate(8);
        return view('home')->with('products', $products);
    }

    public function contact() {
        return view('contact');
    }

    public function catalog() {
        $products = Product::all();
        return view('catalog')->with('products', $products);
    }

    public function cart() {
        if (Auth::user()) {
            $cart = Auth::user() -> cart;
            if ($cart) {
                $products = $cart -> products;
                if (!count($products) == 0)
                    return view('cart')->with('cart', $products);
            }
        } else {
            $token = Cookie::get('basket_token');
            if ($token) {
                $cart = Cart::where('token', $token)->first();
                if ($cart) {
                    $products = $cart -> products;
                    if (!count($products) == 0)
                        return view('cart')->with('cart', $products);
                }
            }
        }
        $products = Product::paginate(4);
        return view('cart')->with('products', $products);
    }

    public function beforeOrder() {
        if (Auth::user()) {
            if (Auth::user() -> cart) {
                $cart_count = count(Auth::user() -> cart -> products);
                if ($cart_count > 0)
                    return view('order');
            } else
                return redirect('/koszyk');
        } else {
            $cart = Cart::where('token', Cookie::get('basket_token'))->first();
            if ($cart)
                return view('before-order');
            else
                return redirect('/koszyk');
        }
    }

    public function order() {
        return view('order');
    }

    public function authenticateBeforeOrder(Request $req) {
        $credentials = $req -> only('email', 'password');
        if (Auth::attempt($credentials)) {
            $cart = Cart::where('token', Cookie::get('basket_token'))->first();
            $oldCart = Cart::where('user_id', Auth::id())->first();
            if ($oldCart)
                $oldCart -> delete();
            if ($cart) {
                $cart -> user_id = Auth::id();
                $cart -> save();
            }
            return redirect()->intended('/zamowienie');
        }
    }

    // API

    public function getProductsFromCart($cart_id) {
        return CartPart::join('products', 'carts_products.product_id', '=', 'products.id') -> where('cart_id', $cart_id)->get(['carts_products.id', 'carts_products.price', 'carts_products.items', 'products.quantity', 'products.image', 'products.link', 'products.name']);
    }

    public function getTotal($cart_id) {
        return Cart::find($cart_id) -> total;
    }
}
