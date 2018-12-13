<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class MainTranslationsTableSeeder extends Seeder {
    public function run()
    {
        DB::table('main_translations')->truncate();
    }
}
