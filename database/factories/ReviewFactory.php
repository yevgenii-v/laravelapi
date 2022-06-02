<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{

    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title'             => $this->faker->sentence,
            'description'       => $this->faker->paragraph,
            'rating'            => rand(7, 10),
            'product_id'        => Product::all()->random()->id,
            'user_id'           => User::all()->random()->id,
        ];
    }
}
