<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brand')->insert([
            'name' => ['湊川あい', '掌田 津耶乃', '溝尾 良隆' , 'ASDF' , '尾田栄一郎'],
        ]);
    }
}
