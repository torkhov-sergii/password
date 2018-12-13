<?php

use Illuminate\Database\Seeder;
//use Pingpong\Trusty\Role;
//use Illuminate\Support\Str;
// composer require laracasts/testdummy
//use Laracasts\TestDummy\Factory as TestDummy;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    public function run()   {
	    DB::table('roles')->truncate();
	    DB::table('role_user')->truncate();
	    DB::table('permission_role')->truncate();

        $superadmin = Role::create([
            'name'          =>  'superadmin',
            'description'   =>  'Super Administrator (all features)'
        ]);

        $admin = Role::create([
            'name'          =>  'admin',
            'description'   =>  'Site Administrator (trimmed functional administration system)'
        ]);

	    $user = Role::create([
		    'name'          =>  'user',
		    'description'   =>  'User (the entrance to the administration panel is closed)'
	    ]);

	    $superadmin->attachPermissions([1,2,3,4,5,6,7,8,9,10]);
        $admin->attachPermissions([1,2,3,4,6,7,8]);
    }
}
