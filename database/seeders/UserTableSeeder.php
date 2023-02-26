<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@test.com',
        //     'password' => Hash::make('password'),
        //     'address' => Str::random(10).'|'.Str::random(10).'|'.Str::random(10).'|'.Str::random(10).'|'.Str::random(10),
        //     'role' => mt_rand(1, 3),
        // ]);
        User::factory()->count(10)
        ->create();

    }
}
