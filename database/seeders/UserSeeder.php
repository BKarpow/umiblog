<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = new User();
        $admin->name = 'Bogdan';
        $admin->phone = '+380932812555';
        $admin->email = 'dexby101@gmail.com';
        $admin->password = Hash::make('123123123');
        $admin->role = User::ROLE_ADMIN;
        $admin->save();
        $faker = Faker\Factory::create();
        foreach(range(1, 40) as $item) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
                'phone' => $faker->phoneNumber,
                'created_at' => now(),
            ]);
        }

    }
}
