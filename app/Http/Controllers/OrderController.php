<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Cart;
use App\CartPart;
use App\Order;
use App\User;
use App\Product;

class OrderController extends Controller
{
    // API

    public function index(Request $req) {
        if (!$req -> _token)
            return ['status' => 400];
        if ($req -> user_id)
            $cart_id = User::find($req -> user_id) -> cart -> id;
        else {
            $token = Cookie::get('basket_token');
            $cart = Cart::where('token', $token)->first();
            if (!$cart)
                return ['status' => 404];
            $cart_id = $cart -> id;
        }

        return CartPart::join('products', 'carts_products.product_id', '=', 'products.id')->where('cart_id', $cart_id)->get(['carts_products.id', 'carts_products.price', 'carts_products.items', 'products.image', 'products.link', 'products.name']);
    }

    public function total(Request $req) {
        if (!$req -> _token)
            return ['status' => 400];
        if ($req -> user_id)
            $total = User::find($req -> user_id) -> cart -> total;
        else {
            $token = Cookie::get('basket_token');
            $cart = Cart::where('token', $token)->first();
            if (!$cart)
                return ['status' => 404];
            $total = $cart -> total;
        }
        return ['total' => $total];
    }

    public function ifUserHaveAddress(Request $req) {
        if (!$req -> _token)
            return ['status' => 400];
        if ($req -> user_id)
            $countAddresses = count(User::find($req -> user_id) -> addresses);
        else {
            return ['status' => 400];
        }
        if ($countAddresses != 0)
            $haveAddress = true;
        else
            $haveAddress = false;
        return ['haveAddress' => $haveAddress];
    }

    public function create(Request $req) {
        if (!$req -> _token)
            abort(401);
        if ($req -> user_id) {
            $cart_id = User::find($req -> user_id) -> cart -> id;
            $cart = Cart::find($cart_id);
        } else {
            $token = Cookie::get('basket_token');
            $cart = Cart::where('token', $token)->first();
            if (!$cart)
                return ['status' => 404];
            $cart_id = $cart -> id;
        }

        $order = new Order();

        // Order code
        if ($req -> user_id)
            $code = $req -> user_id.'0'.date('Ymds').'0'.$cart_id;
        else
            $code = '00'.date('Ymds').'0'.$cart_id;
        $order -> code = $code;

        $order -> user_id = $req -> user_id;
        $order -> email = $req -> email;
        $order -> delivery_method = $req -> delivery_method;
        if ($req -> delivery_method != 'courier')
            $order -> delivery_place = $req -> delivery_place;
        $order -> payment_method = $req -> payment_method;
        $order -> purchaser_type = $req -> type;
        $order -> name = $req -> name;
        $order -> surname = $req -> surname;
        $order -> company_name = $req -> company_name;
        $order -> nip_code = $req -> nip_code;
        $order -> telephone = $req -> telephone;
        $order -> street = $req -> street;
        $order -> house_number = $req -> house_number;
        $order -> apartment_number = $req -> apartment_number;
        $order -> zip_code = $req -> zip_code;
        $order -> city = $req -> city;
        $order -> comment = $req -> comment;
        $order -> cart_id = $cart_id;
        $order -> delivery_price = $req -> delivery_price;
        $order -> total = $req -> total;

        $order -> save();

        // change basket
        $cart -> ordered = 1;
        $cart -> user_id = NULL;
        $cart -> save();

        if ($req -> user_id) {
            $cart -> user_id = $req -> user_id;
        } else {
            Cookie::queue(Cookie::forget('basket_token'));
        }

        foreach (Cart::find($cart_id) -> products as $product) {
            $product_id = $product -> product_id;
            $items = $product -> items;

            $bought_product = Product::find($product_id);

            // change purchased
            $bought_product -> purchased += $items;

            // change availability
            $bought_product -> quantity -= $items;

            if ($bought_product -> quantity == 0)
                $bought_product -> availability = 0;

            $bought_product -> save();
        }

        // Check other carts
        $carts = Cart::where('ordered', 0)->get();
        foreach ($carts as $cart) {
            foreach($cart -> products as $product) {
                $product_id = $product -> product_id;
                $cartPart_id = $product -> id;
                $items = $product -> items;

                $bought_product = Product::find($product_id);

                if ($bought_product -> availability == 0) {
                    CartPart::destroy($cartPart_id);
                    $cart -> total -= $product -> price;
                    $cart -> save();
                    if (count(Cart::find($cart -> id) -> products) == 0) {
                        Cart::destroy($cart -> id);
                    }
                } else {
                    if ($bought_product -> quantity < $items) {
                        $cartPart = CartPart::find($cartPart_id);
                        $cart -> total -= $cartPart -> price;
                        $cartPart -> items = $bought_product -> quantity;
                        $cartPart -> price = $bought_product -> price * $bought_product -> quantity;
                        $cart -> save();
                        $cartPart -> save();
                        $cart -> total += $cartPart -> price;
                        $cart -> save();
                    }
                }
            }
        }

        if (!$req -> user_id)
            return response(['status' => 200]);
        return ['status' => 200, 'redirect' => true];
    }

    public function list(Request $req) {
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        $orders = User::find($req -> user_id) -> orders;
        return $orders;
    }
}
