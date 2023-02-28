<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('brands')->insert([
        //     'name' => ['Tools Book', 'Manga', 'Travel Book'],
        // ]);
        Brand::factory()->count(10)->create();
    }
}
