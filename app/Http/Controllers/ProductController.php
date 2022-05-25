<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartPart;
use Illuminate\Http\Request;
use App\Product;
use App\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index($name) {
        $productId = explode('-', $name)[0];
        $product = Product::find($productId);
        return view('product')->with('product', $product);
    }

    public function search() {
        return view('search-results');
    }

    // API

    public function getQuantity($id) {
        return Product::find($id) -> quantity;
    }

    public function searchProducts($q, $sortBy = 'NR') {
        switch ($sortBy) {
            case 'NR':
                $sort = ['name', 'asc'];
                break;
            case 'NM':
                $sort = ['name', 'desc'];
                break;
            case 'CR':
                $sort = ['price', 'asc'];
                break;
            case 'CM':
                $sort = ['price', 'desc'];
                break;
            case 'DR':
                $sort = ['created_at', 'asc'];
                break;
            case 'DM':
                $sort = ['created_at', 'desc'];
                break;
        }
        return Product::where('name','like', '%'.$q.'%')->orderBy($sort[0], $sort[1])->get();
    }

    public function addToCart(Request $req) {
        $product = Product::find($req -> product_id);
        $user = User::find($req -> user_id);
        if ($product) {
            if ($user) {
                if ($user -> cart) {
                    $cart = Cart::find($user -> cart -> id);
                    $cartPart = CartPart::where('cart_id', $cart -> id)->where('product_id', $req -> product_id)->first();
                    if ($cartPart) {
                        if (Product::find($req -> product_id) -> quantity == $cartPart -> items)
                            return ['status' => 'error', 'message' => 'Przekroczono limit dostępnych produktów'];
                        $cartPart -> items = $cartPart -> items + $req -> quantity;
                        if (Product::find($req -> product_id) -> quantity < $cartPart -> items) {
                            $cartPart -> items = Product::find($req -> product_id) -> quantity;
                            $cart -> total = $cart -> total - $cartPart -> price;
                            $cart -> total = $cart -> total + Product::find($req -> product_id) -> price * $cartPart -> items;
                            $cart -> save();
                            $warning = True;
                        }
                        $cartPart -> price = Product::find($req -> product_id) -> price * $cartPart -> items;
                        $cartPart -> save();

                        if (isset($warning))
                            return ['status' => 'warning', 'message' => 'Dodano maksymalną ilość produktów'];
                        $cart -> total = $cart -> total + Product::find($req -> product_id) -> price * $req -> quantity;
                        $cart -> save();
                        return ['status' => 200];
                    }
                } else {
                    $cart = new Cart();
                    $cart -> user_id = $req -> user_id;
                    $cart -> total = '0.00';
                    $cart -> save();
                }
            } else {
                $token = Cookie::get('basket_token');
                if ($token) {
                    $cart = Cart::where('token', $token)->first();
                    if (!$cart) {
                        Cookie::queue(Cookie::forget('basket_token'));
                        $cart = new Cart();
                        $cart -> total = '0.00';
                        $cart -> save();
                    } else {
                        $cartPart = CartPart::where('cart_id', $cart -> id)->where('product_id', $req -> product_id)->first();
                        if ($cartPart) {
                            if (Product::find($req -> product_id) -> quantity == $cartPart -> items)
                                return ['status' => 'error', 'message' => 'Przekroczono limit dostępnych produktów'];
                            $cartPart -> items = $cartPart -> items + $req -> quantity;
                            if (Product::find($req -> product_id) -> quantity < $cartPart -> items) {
                                $cartPart -> items = Product::find($req -> product_id) -> quantity;
                                $cart -> total = $cart -> total - $cartPart -> price;
                                $cart -> total = $cart -> total + Product::find($req -> product_id) -> price * $cartPart -> items;
                                $cart -> save();
                                $warning = True;
                            }
                            $cartPart -> price = Product::find($req -> product_id) -> price * $cartPart -> items;
                            $cartPart -> save();

                            if (isset($warning))
                                return ['status' => 'warning', 'message' => 'Dodano maksymalną ilość produktów'];
                            $cart -> total = $cart -> total + Product::find($req -> product_id) -> price * $req -> quantity;
                            $cart -> save();
                            return ['status' => 200];
                        }
                    }
                } else {
                    $cart = new Cart();
                    $cart -> total = '0.00';
                    $cart -> save();
                }
            }
            $token = Str::random(40);

            $cartPart = new CartPart();
            $cartPart -> cart_id = $cart -> id;
            $cartPart -> product_id = $req -> product_id;
            $cartPart -> items = $req -> quantity;
            $cartPart -> price = (Product::find($req -> product_id) -> price) * $req -> quantity;
            $cartPart -> save();
            $cart -> token = $token;
            $cart -> total = $cart -> total + $cartPart -> price;
            $cart -> save();
            if (!isset($cart_id)) {
                return response(['status' => 200])->withCookie(cookie()->forever('basket_token', $token));
            }
            return ['status' => 200];

        } else
            return ['status' => 400];
    }

    public function UpdateCart(Request $req) {
        if (!$req -> _token) {
            abort(401);
        }
        $product = CartPart::find($req -> product_id);
        $cart = Cart::find($req -> cart_id);
        if ($cart) {
            if ($product) {
                $cart -> total = $cart -> total - $product -> price;

                $product -> items = $req -> items;
                $product -> price = Product::find($product -> product_id) -> price * $req -> items;
                $product -> save();

                $cart -> total = $cart -> total + $product -> price;
                $cart -> save();

                return ['status' => 200];
            }
        }
        return ['status' => 400];
    }

    public function removeFromCart(Request $req) {
        if (!$req -> _token)
            return ['status' => 400];
        $product = CartPart::find($req -> product_id);
        $cart = Cart::find($req -> cart_id);
        if ($cart) {
            if ($product) {
                $cart -> total = $cart -> total - $product -> price;
                $cart -> save();
                $product -> delete();
                if (count($cart -> products) == 0)
                    $cart -> delete();
                return ['status' => 200];
            }
        }
        return ['status' => 400];
    }
}
