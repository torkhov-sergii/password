<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('users')->delete();

		$faker = Faker\Factory::create('ru_RU');
		$faker->seed(1234);

		$users[] = [
			'id' => '1',
			'login' => 'qverty',
			'email' => 'torhov.s@gmail.com',
			'password' => '$2y$10$ZNowCxGIGYaI1B1KccXqJe2nb/MrOOm4ECXCS3ibdIau2ofux4lim',
			'name' => 'Сергей',
			'surname' => 'Торхов',
			'secondname' => 'Сергеевич',
			'dateofbirth' => '1983-01-22',
			'phone' => '+380685915513',
			'verified' => '1',
			'created_at' => '2015-05-11 13:40:18',
		];

		$users[] = [
			'id' => '2',
			'login' => 'admin',
			'email' => '',
			'password' => '$2y$10$D4e4hx6J9IZkUWq.48TyKOuUEjG/DQrChHL97PCkpdcTu.9.gSmCi',
			'name' => 'Admin',
			'surname' => '',
			'secondname' => '',
			'dateofbirth' => '2000-01-01',
			'phone' => '',
			'verified' => '1',
			'created_at' => '2015-05-10 13:40:18',
		];

//		for ($i=10; $i <= 30; $i++) {
//			$users[] = [
//				'id' => $i,
//				'login' => $faker->userName,
//				'email' => $faker->email,
//				'password' => '',
//				'name' => $faker->firstName,
//				'surname' => $faker->lastName,
//				'secondname' => '',
//				'dateofbirth' => $faker->dateTimeBetween('-60 years', '-15 years')->format('Y-m-d'),
//				'phone' => $faker->phoneNumber,
//				'verified' => '1',
//				'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
//			];
//		}

		DB::table('users')->insert($users);

		//добавляем пользователям роли
		$userModel = new \App\Models\User();
		$userModel->getUser(1)->attachRole(1);
		$userModel->getUser(2)->attachRole(2);
	}
}
