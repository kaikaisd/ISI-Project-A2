<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Product::class;

    protected $nameList = [
        'git',
        'swift',
        'ruby',
        'aws',
        'golang',
        'SQL',
        'bochi',
        'yurucamp',
        'eromanga sensei',
        'one piece',
        'first time go to other country',
        'Global maps',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $rand = mt_rand(0, count($this->nameList) - 1);
        return [
            'name' => $this->nameList[$rand],
            'price' => mt_rand(1000.00, 100000.00),
            'description' => Str::random(10),
            'brand_id' => mt_rand(1, 10),
            'category_id' => mt_rand(1, 10),
            'quantity' => mt_rand(1, 100),
            'isOnSale' => mt_rand(0, 1),
            'isOverSale' => mt_rand(0, 1),
            'isPromotion' => mt_rand(0, 1),
            'promoPrice' => mt_rand(1000.00, 100000.00),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'isbn' => fake()->isbn13(),
            'pages' => mt_rand(100, 1000),
            'release_date' => $this->faker->dateTimeBetween('-1 years', 'now'),

        ];
    }
}
