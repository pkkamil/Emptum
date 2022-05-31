<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryPlace;
use App\User;

class DeliveryPlaceController extends Controller
{
    // API

    public function index(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);

        return DeliveryPlace::all();
    }

    public function store(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);

        $place = new DeliveryPlace();
        $place -> name = $req -> name;
        $place -> street = $req -> street;
        $place -> house_number = $req -> house_number;
        $place -> apartment_number = $req -> apartment_number;
        $place -> zip_code = $req -> zip_code;
        $place -> city = $req -> city;
        $place -> save();
        return ['status' => 200];
    }

    public function show(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);

        $place = DeliveryPlace::find($req -> place_id);
        if (!$place)
            abort(404);
        else
            return $place;
    }

    public function update(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);

        $place = DeliveryPlace::find($req -> place_id);
        $place -> name = $req -> name;
        $place -> street = $req -> street;
        $place -> house_number = $req -> house_number;
        if ($req -> apartment_number == "")
            $place -> apartment_number = "";
        else
            $place -> apartment_number = $req -> apartment_number;
        $place -> zip_code = $req -> zip_code;
        $place -> city = $req -> city;
        $place -> save();
        return ['status' => 200];
    }

    // public function destroy(Request $req) {
    //     // Security
    //     if (!$req -> _token)
    //         abort(401);
    //     if (!$req -> user_id)
    //         abort(401);
    //     if (User::find($req -> user_id) -> role != 'admin')
    //         abort(401);

    //     $place = DeliveryPlace::find($req -> place_id);
    //     if (!$place)
    //         abort(404);
    //     return $place -> delete();
    // }
}
