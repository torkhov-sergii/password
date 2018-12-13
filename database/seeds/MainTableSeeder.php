<?php

use Illuminate\Database\Seeder;
use App\Models\Main;

class MainTableSeeder extends Seeder
{
    public function run() {
        DB::table('main')->truncate();

        $root = Main::create(['slug' => 'root']);
    }
}
