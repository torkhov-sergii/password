<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	//$faker = Faker\Factory::create('ru_RU');
	//$faker->seed(1234);
	//echo '<br>';
	//echo '<br>'.$faker->name;
	//echo '<br>'.$faker->country;
	//echo '<br>'.$faker->city;
	//echo '<br>'.$faker->address;
	//echo '<br>'.$faker->company;
	//echo '<br>'.$faker->phoneNumber;
	//echo '<br>'.$faker->text(500);
	//echo '<br>'.$faker->randomDigit;
	//echo '<br>'.$faker->numberBetween($min = 1000, $max = 9000);
	//echo '<br>'.$faker->unixTime;
	//echo '<br>'.$faker->dateTime;
	//echo '<br>'.$faker->dateTimeBetween('-1 years', 'now');
	//echo '<br>'.$faker->email;
	//echo '<br>'.$faker->domainName;
	//echo '<br>'.$faker->imageUrl(640, 480);

	//если не находит класс, то выполнить это
	//composer dumpautoload

	public function run()
	{
		Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //убрать ошибку truncate
		//если не находит класс, то выполнить это composer dumpautoload
//		$this->call('PermissionTableSeeder');
//        $this->call('RoleTableSeeder');
//		$this->call('UserTableSeeder');
//		$this->call('MainTableSeeder');
//		$this->call('MainTranslationsTableSeeder');
//		$this->call('TypeTableSeeder');

		//$this->call('ImportArticlesSeeder');
		//$this->call('ImportNewsSeeder');
		//если не находит класс, то выполнить это composer dumpautoload
		DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //установить ошибку truncate
	}

}
