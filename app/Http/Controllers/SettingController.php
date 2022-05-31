<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $req) {
        // Security
        if (!$req -> _token)
           abort(401);
        if (!$req -> user_id)
           abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
           abort(401);

        $settings = array(
            "welcome_box_text" => Setting::where('name', 'welcome_box_text')->pluck('value')->first(),
            "welcome_box_button_text" => Setting::where('name', 'welcome_box_button_text')->pluck('value')->first()
        );

        return $settings;
    }

    public function changeHomepageBackground(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);
        Storage::disk('public_folder')->put('/assets/img/bg-homepage.jpg', file_get_contents($req -> image));
        return ['status' => 200];
    }

    public function changeWelcomeBoxText(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);

        $setting = Setting::where('name', 'welcome_box_text')->first();
        $setting -> value = $req -> value;
        $setting -> save();
        return ['status' => 200];
    }

    public function changeWelcomeBoxButtonText(Request $req) {
        // Security
        if (!$req -> _token)
            abort(401);
        if (!$req -> user_id)
            abort(401);
        if (User::find($req -> user_id) -> role != 'admin')
            abort(401);

        $setting = Setting::where('name', 'welcome_box_button_text')->first();
        $setting -> value = $req -> value;
        $setting -> save();
        return ['status' => 200];
    }
}
