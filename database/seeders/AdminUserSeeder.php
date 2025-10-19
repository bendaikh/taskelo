<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
	public function run(): void
	{
		$email = env('ADMIN_EMAIL', 'admin@example.com');
		$password = env('ADMIN_PASSWORD', 'admin12345');

		$user = DB::table('users')->where('email', $email)->first();
		if ($user) {
			DB::table('users')->where('id', $user->id)->update([
				'name' => 'Administrator',
				'password' => Hash::make($password),
				'updated_at' => now(),
			]);
			return;
		}

		DB::table('users')->insert([
			'name' => 'Administrator',
			'email' => $email,
			'password' => Hash::make($password),
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
}


