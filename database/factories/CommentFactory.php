<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Создает нового пользователя, если не передан существующий
            'title' => $this->faker->sentence(),
            'text' => $this->faker->paragraph(),
            'recommended' => $this->faker->boolean(20), // 20% вероятности true
        ];
    }
}
