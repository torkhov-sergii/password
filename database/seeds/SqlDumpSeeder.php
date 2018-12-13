<?php

use Illuminate\Database\Seeder;

class SqlDumpSeeder extends Seeder
{
	public function run()
	{
        DB::unprepared(file_get_contents('database/dump.sql'));
	}
}
