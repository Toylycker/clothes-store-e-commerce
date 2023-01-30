<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seller;
use App\Models\Location;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */

class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'location_id' => Location::inRandomOrder()->first(),
            'user_id' => $this->faker->unique()->numberBetween($min = 2, $max = 10),
            'seller_name' => $this->faker->unique()->name(),
            'seller_last_name' => $this->faker->unique()->lastName(),
            'seller_phone' => '86' . rand(2000000, 5999999),
            'shop_address' => $this->faker->unique()->streetAddress(),
            'company_name' => $this->faker->unique()->company(),
        ];
    }
}
