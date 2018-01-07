<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $faker = \Faker\Factory::create();

        $pass = Hash::make('collabos');

        User::create([
           'name'       =>  'knubbe',
           'email'      =>  'knubbe@test.com',
           'password'   => $pass
        ]);

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name'  => $faker->name,
                'email' => $faker->email,
                'password'  => $pass
            ]);
        }
    }
}
