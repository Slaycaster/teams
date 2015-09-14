<?php

	class UserTableSeeder extends Seeder
	{
		public function run()
		{
			DB::table('users')->delete();
			User::create(array(

				'name'     => 'Denimar Fernandez',
				'username' => 'admin',
				'email'    => 'teams@FareMatrix.com',
				'password' => Hash::make('admin'),
				));
		}

	}