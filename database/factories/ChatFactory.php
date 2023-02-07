<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class ChatFactory extends Factory
{

    public function configure()
    {
        return $this->afterMaking(function (Chat $chat) {
            //
        })->afterCreating(function (Chat $chat) {
            $user_id_1 = User::inRandomOrder()->first()->id;
            $user_id_2 = $this->faker->unique()->numberBetween($min = 1, $max = 30);
            while($user_id_1==$user_id_2){
                $user_id_2 = $this->faker->unique()->numberBetween($min = 1, $max = 30);
            }
            $chat->users()->attach([$user_id_1, $user_id_2]);
            
            Message::create([
                'chat_id'=>$chat->id,
                'content'=>$this->faker->word, 
            'from_id'=>$user_id_1, 
            'to_id'=>$user_id_2]);

            Message::create([
                'chat_id'=>$chat->id,
                'content'=>$this->faker->word, 
            'from_id'=>$user_id_2, 
            'to_id'=>$user_id_1]);

            echo('chat '. $chat->id .' done');
        });}



    public function definition()
    {
        return [
        ];
    }
}
