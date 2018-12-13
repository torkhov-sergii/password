<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('login')->nullable()->unique();
			$table->string('email')->nullable()->unique();
			$table->string('password', 60)->nullable();

			$table->string('name')->nullable()->default('');;
			$table->string('surname')->nullable()->default('');;
			$table->string('secondname')->nullable()->default('');;
			$table->date('dateofbirth')->nullable();
			$table->string('phone')->nullable()->default('');

			//$table->enum('VerificationStatus', ['', 'consideration', 'allow', 'correction', 'disallow']);

			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
