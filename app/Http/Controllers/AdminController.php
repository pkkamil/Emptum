<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index() {
        $carts = count(Cart::all());
        $orders = count(Order::all());
        $products = count(Product::all());
        return view('admin', compact('carts', 'orders', 'products'));
    }

    public function carts() {
        $carts = Cart::paginate(10);
        return view('cart-list')->with('carts', $carts);
    }

    public function cart($id) {
        $cart = Cart::find($id);
        return view('cart-view')->with('cart', $cart);
    }

    public function deleteCart(Request $req) {
        if (Auth::user() -> role != 'admin')
            return redirect('/');
        if (Cart::find($req -> cart_id) -> ordered == 0)
            Cart::destroy($req -> cart_id);
        if (count(Cart::all()) != 0)
            return redirect('/admin/koszyki');
        else
            return redirect('/admin');
    }

    public function orders() {
        $orders = Order::orderBy('ordered_at', 'desc')->paginate(10);
        return view('order-list')->with('orders', $orders);
    }

    public function order($id) {
        $order = Order::find($id);
        return view('order-view')->with('order', $order);
    }

    public function deleteOrder(Request $req) {
        if (Auth::user() -> role != 'admin')
            return redirect('/');
        $cart = Cart::find(Order::find($req -> order_id) -> cart_id);
        $cart -> ordered = 0;
        $cart -> save();
        Order::destroy($req -> order_id);
        if (count(Order::all()) != 0)
            return redirect('/admin/zamowienia');
        else
            return redirect('/admin');
    }

    public function products() {
        $products = Product::paginate(10);
        return view('product-list')->with('products', $products);
    }

    public function product($id) {
        $product = Product::find($id);
        return view('product-view')->with('product', $product);
    }

    public function deleteProduct(Request $req) {
        if (Auth::user() -> role != 'admin')
            return redirect('/');
        Product::destroy($req -> product_id);
        if (count(Product::all()) != 0)
            return redirect('/admin/produkty');
        else
            return redirect('/admin');
    }

    // API

    public function getLastProductID(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role == 'admin') {
            if (count(Product::all()) != 0)
                return Product::all() -> last() -> id + 1;
            else
                return 1;
        }
    }

    public function addNewProduct(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);
        $product = new Product();
        if ($req -> id)
            $product -> id = $req -> id;
        $product -> name = $req -> name;
        $product -> description = $req -> description;
        $imgName = $req -> id.Str::random(10);
        Storage::put('/public/products/'.$imgName, file_get_contents($req -> image));
        $product -> image = '/storage/products/'.$imgName;
        $product -> link = $req -> link;
        $product -> quantity = $req -> quantity;
        $product -> price = $req -> price;
        $product -> save();
        return ['status' => 200];
    }

    public function loadProduct(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);
        if (!$req -> product_id)
            abort(404);

        $product = Product::find($req -> product_id);
        if ($product)
            return $product;
        else
            abort(404);
    }

    public function editProduct(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);
        if (!$req -> product_id)
            abort(404);
        $product = Product::find($req -> product_id);
        if (!$product)
            abort(404);
        $product -> name = $req -> name;
        $product -> description = $req -> description;
        if ($product -> image != $req -> image) {
            Storage::delete(str_replace('storage', 'public', $product -> image));
            $imgName = $req -> id.Str::random(10);
            Storage::put('/public/products/'.$imgName.'.jpg', file_get_contents($req -> image));
            $product -> image = '/storage/products/'.$imgName.'.jpg';
        }
        $product -> link = $req -> link;
        $product -> quantity = $req -> quantity;
        if ($req -> quantity > 0)
            $product -> availability = 1;
        else
            $product -> availability = 0;
        $product -> price = $req -> price;
        $product -> save();
        return ['status' => 200];
    }

    public function changeOrderStatus(Request $req) {
            // Security
            if (!$req -> _token)
                abort(401);
            if (!$req -> user_id)
                abort(401);
            if (User::find($req -> user_id) -> role != 'admin')
                abort(401);
            if (!$req -> order_id)
                abort(404);
            $order = Order::find($req -> order_id);
            if (!$order)
                abort(404);
            $order -> status = $req -> status;

            if ($order -> included) {
                if ($order -> status == 'returned' || $order -> status == 'cancelled') {
                    foreach (Cart::find($order -> cart_id) -> products as $product) {
                        $product_id = $product -> product_id;
                        $items = $product -> items;

                        $bought_product = Product::find($product_id);

                        // change purchased
                        $bought_product -> purchased -= $items;

                        // change availability
                        $bought_product -> quantity += $items;

                        if ($bought_product -> quantity > 0)
                            $bought_product -> availability = 1;

                        $bought_product -> save();
                    }
                    $order -> included = 0;
                }
            } else {
                if ($order -> status == 'ordered' || $order -> status == 'accepted' || $order -> status == 'sent' || $order -> status == 'delivered') {
                    foreach (Cart::find($order -> cart_id) -> products as $product) {
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
                    $order -> included = 1;
                }
            }

            $order -> save();
            return ['status' => 200];
    }
}
