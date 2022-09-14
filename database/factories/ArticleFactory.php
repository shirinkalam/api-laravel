<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'     => User::where('email','mahdishiri869@gmail.com')->first()->id,
            'title'       => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'image'       => $this->faker->imageUrl(),
        ];
    }
}
