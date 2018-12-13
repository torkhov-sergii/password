<?php

use Illuminate\Database\Seeder;
//use Pingpong\Trusty\Permission;
use Illuminate\Support\Str;
// composer require laracasts/testdummy
//use Laracasts\TestDummy\Factory as TestDummy;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run() {
	    DB::table('permissions')->truncate();

	    Permission::create([
		    'name'          =>  'admin',
		    'description'   =>  'Login Administration System'
	    ]);

	    Permission::create([
		    'name'          =>  'role',
		    'description'   =>  'Role Section'
	    ]);

	    Permission::create([
		    'name'          =>  'main',
		    'description'   =>  'Site Section'
	    ]);

	    Permission::create([
		    'name'          =>  'user',
		    'description'   =>  'User Section'
	    ]);

	    Permission::create([
		    'name'          =>  'type',
		    'description'   =>  'Type Section'
	    ]);

	    Permission::create([
		    'name'          =>  'seo',
		    'description'   =>  'Seo Section'
	    ]);

	    Permission::create([
		    'name'          =>  'translations',
		    'description'   =>  'Translations Section'
	    ]);

	    Permission::create([
		    'name'          =>  'settings',
		    'description'   =>  'Settings Section'
	    ]);

	    Permission::create([
		    'name'          =>  'backup',
		    'description'   =>  'Backup Section'
	    ]);

	    Permission::create([
		    'name'          =>  'tags',
		    'description'   =>  'Tags Section'
	    ]);
    }
}
