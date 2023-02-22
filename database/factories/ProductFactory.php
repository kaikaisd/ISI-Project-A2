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

    protected $picList = [
        // Coding
        'https://m.media-amazon.com/images/I/51fsPIs9pTS.jpg', //git
        'https://m.media-amazon.com/images/I/511W5MnKaEL.jpg', //swift
        'https://m.media-amazon.com/images/I/71SI-f8WqUL.jpg', //ruby
        'https://m.media-amazon.com/images/I/91rn6pHakhL.jpg', //aws
        'https://m.media-amazon.com/images/I/71ueTA1g6FL.jpg', //golang
        'https://m.media-amazon.com/images/I/810UhT+Xu2L.jpg', //SQL

        // Manga
        'https://m.media-amazon.com/images/I/81Boule4weL.jpg', //bochi
        'https://m.media-amazon.com/images/I/91xlEcfLA8L.jpg', //yurucamp
        'https://m.media-amazon.com/images/I/81HIeThGcrL.jpg', //eromanga sensei
        'https://m.media-amazon.com/images/I/81Y-cktRWbL.jpg', //one piece

        // Tutorial
        'https://m.media-amazon.com/images/I/91yCBGgbT8L.jpg', //first time go to other country
        'https://m.media-amazon.com/images/I/81DizLXutBL.jpg', //Global maps
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
            'image' => $this->picList[$rand],
            'quantity' => mt_rand(1, 100),
            'isOnSale' => mt_rand(0, 1),
            'isOverSale' => mt_rand(0, 1),
            'isPromotion' => mt_rand(0, 1),
            'promoPrice' => mt_rand(1000.00, 100000.00),
        ];
    }
}
