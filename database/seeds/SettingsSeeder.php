<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site-settings')->insert([
            'name' => 'welcome_box_text',
            'value' => 'Przeglądaj wspaniałe produkty',
        ]);
        DB::table('site-settings')->insert([
            'name' => 'welcome_box_button_text',
            'value' => 'Przeglądaj',
        ]);
        DB::table('site-settings')->insert([
            'name' => 'delivery_price',
            'value' => '19.50',
        ]);
    }
}
