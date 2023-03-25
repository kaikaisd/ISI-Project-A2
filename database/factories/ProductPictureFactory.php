<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductPictureFactory extends Factory
{

    protected $model = \App\Models\ProductPicture::class;

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
        return [
            'product_id' => mt_rand(1, 10),
            'path' => $this->picList[mt_rand(1,10)],
            'order' => $this->faker->numberBetween(1, 5)
        ];
    }
}
