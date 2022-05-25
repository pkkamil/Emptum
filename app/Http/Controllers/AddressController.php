<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
    // API

    public function index(Request $req) {
        if (!$req -> _token)
            abort(401);
        return Address::where('user_id', $req -> user_id)->get();
    }

    public function store(Request $req) {
        if (!$req -> _token)
            abort(401);
        $address = new Address();
        $address -> type = $req -> type;
        $address -> name = $req -> name;
        $address -> surname = $req -> surname;
        $address -> company_name = $req -> company_name;
        $address -> nip_code = $req -> nip_code;
        $address -> telephone = $req -> telephone;
        $address -> street = $req -> street;
        $address -> house_number = $req -> house_number;
        $address -> apartment_number = $req -> apartment_number;
        $address -> zip_code = $req -> zip_code;
        $address -> city = $req -> city;
        $address -> user_id = $req -> user_id;
        $address -> save();
        return ['status' => 200];
    }

    public function show(Request $req) {
        if (!$req -> _token)
            abort(401);
        $address = Address::where('user_id', $req -> user_id) -> where('id', $req -> address_id)->first();
        if (!$address)
            abort(404);
        else
            return $address;
    }

    public function update(Request $req) {
        if (!$req -> _token)
            abort(401);
        $address = Address::where('user_id', $req -> user_id) -> where('id', $req -> address_id)->first();
        $address -> type = $req -> type;
        $address -> name = $req -> name;
        $address -> surname = $req -> surname;
        $address -> company_name = $req -> company_name;
        $address -> nip_code = $req -> nip_code;
        $address -> telephone = $req -> telephone;
        $address -> street = $req -> street;
        $address -> house_number = $req -> house_number;
        $address -> apartment_number = $req -> apartment_number;
        $address -> zip_code = $req -> zip_code;
        $address -> city = $req -> city;
        $address -> user_id = $req -> user_id;
        $address -> save();
        return ['status' => 200];
    }

    public function destroy(Request $req) {
        if (!$req -> _token)
            abort(401);
        $address = Address::find($req -> address_id);
        if (!$address)
            abort(404);
        if ($address -> user_id == $req -> user_id)
            return $address -> delete();
        else
            abort(401);
    }
}
