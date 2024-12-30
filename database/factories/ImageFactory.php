<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->date('Y-m-d h:m:s');
        $images = ['assets/frontend/img/1.jpg', 'assets/frontend/img/2.jpg', 'assets/frontend/img/3.jpg', 'assets/frontend/img/4.jpg', 'assets/frontend/img/5.jpg', 'assets/frontend/img/6.jpg'];
        return [
            'path' => fake()->randomElement($images),
            'created_at' => $date,
            'updated_at' => $date,

        ];
    }
}
