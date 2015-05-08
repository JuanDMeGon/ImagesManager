<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use ImagesManager\Album;
use ImagesManager\User;

class AlbumTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = User::all();

		foreach ($users as $user)
		{
			$number = mt_rand(0,15);

			for ($i=0; $i < $number; $i++)
			{
				Album::create
				(
					[
						'title' => "Title album $i of $user->id",
						'description' => "Description album $i of $user->id",
						'user_id' => $user->id
					]
				);
			}
		}
	}

}
