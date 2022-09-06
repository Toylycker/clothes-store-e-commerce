<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $username = $this->faker->Unique()->name();
        
        return [
            'username'=>$username,
            'password'=> bcrypt($username . '123'),
            'role'=>'user',
            'phone' => rand(860000000, 869999999),
            'mail' => $this->faker->unique()->email
        ];
    }
}
