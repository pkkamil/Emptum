<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $addresses = Auth::user() -> addresses;
        $orders = Auth::user() -> orders;
        return view('account', compact('addresses', 'orders'));
    }

    public function logout() {
        Cookie::queue(Cookie::forget('basket_token'));
        return redirect('/')->with(Auth::logout());
    }

    public function addresses() {
        $addresses = Auth::user() -> addresses;
        return view('addresses')->with('addresses', $addresses);
    }
}
