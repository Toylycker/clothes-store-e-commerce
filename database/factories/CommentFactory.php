<?php

namespace Database\Factories;

use App\Models\Outfit;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $outfit = Outfit::inRandomOrder()->first();
        $comment = $this->faker->paragraph(1, 3);
        $createdAt = $this->faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now');
        return [
            'user_id' => $user->id,
            'outfit_id' => $outfit->id,
            'comment' => $comment,
            'created_at' => $createdAt
        ];
    }
}
