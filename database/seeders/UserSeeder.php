<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        for($i = 0; $i < 20000; $i++) {
            $data[] = [
                'name'              => $faker->name(),
                'email'             => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password'          => $faker->password(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }

        foreach(array_chunk($data, 1000) as $chunk) {
            User::insert($chunk);
        }
    }
}