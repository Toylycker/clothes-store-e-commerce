<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\OrderOutfitSeller;
use App\Models\Location;
use App\Models\OrderItem;
use App\Models\Outfit;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{




    public function configure()
   {
       return $this->afterMaking(function (Order $order) {
           //
       })->afterCreating(function (Order $order) {
           $rand = rand(1, 5);
            for ($i=0; $i < $rand; $i++) { 
                $outfit = Outfit::inRandomOrder()->with('age')->first();
                $detail = new OrderItem();
                $detail->order_id = $order->id;
                $detail->outfit_id = $outfit->id;
                $detail->age_id = $outfit->age->id;
                $detail->quantity = rand(1, 5);
                $detail->discount = rand(1, 5);
                $detail->save();
            }

       });
    }





    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $location = Location::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $note = $this->faker->paragraph(rand(1, 2));
        return [
            'location_id' => $location->id,
            'user_id' => $user->id,
            'order_num' => $user->id . rand(400, 900),
            'phone' => $user->phone,
            'note' => $note
        ];
    }
}
