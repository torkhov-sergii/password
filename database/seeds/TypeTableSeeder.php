<?php

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeTableSeeder extends Seeder {
    public function run()
    {

        DB::table('type')->truncate();

        $root = Type::create(['name' => 'Site']);

//        $child_1 = $root->children()->create(['name' => 'About company']);
//        $child_1_1 = $child_1->children()->create(['name' => 'Team']);
//        $child_1_2 = $child_1->children()->create(['name' => 'Advantages']);
//
//        $child_2 = $root->children()->create(['name' => 'News']);
//
//        $child_3 = $root->children()->create(['name' => 'Gallery']);
//
//        $child_4 = $root->children()->create(['name' => 'Contacts']);
    }
}
