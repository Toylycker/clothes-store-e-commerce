<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Location;
use App\Models\Seller;
use App\Models\Tag;
use App\Models\Age;
use App\Models\Outfit;
use App\Models\Option;
use App\Models\Value;
use App\Models\OutfitSeller;
use Carbon\Carbon;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outfit>
 */
class OutfitFactory extends Factory
{   
    
    /**
    * Configure the model factory.
    *
    * @return $this
    */
   public function configure()
   {
       return $this->afterMaking(function (Outfit $outfit) {
           //
       })->afterCreating(function (Outfit $outfit) {
            $outfit->tags()->sync(Tag::inRandomOrder()->take(rand(1, 5))->pluck('id'));
            $outfit->ages()->syncWithPivotValues(Age::inRandomOrder()->take(rand(1, 3))->pluck('id'), ['quantity'=>2]);

           $name = [];
           $name_en = [];
           $description = [];
           $description_en = [];
           $values = [];
           $search = [];

           $options = Option::with(['values'])
               ->orderBy('sort_order')
               ->orderBy('name')
               ->get();

           foreach ($options as $option) {
               $value = $option->values->random();
                if (in_array($option->id, [1, 2, 4])) {
                    $name[] = $value->name;
                    $name_en[] = $value->name_en;
                }
               $description[] = $option->name . ': ' . $value->name;
               $description_en[] = $option->name_en . ': ' . $value->name_en;
               $search[] = $value->name;
               $search[] = $value->name_en;
               $values[$value->id] = ['sort_order' => $option->sort_order];
           }


            $createdAt = $this->faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now');
                $outfit->description = implode(", ", $description) . '.';
                $outfit->description_en = implode(", ", $description_en) . '.';
                $outfit->price =rand(100,1000);
                $outfit->stock =rand(0,100);
                $outfit->sold =rand(0,100);
                $outfit->discount_percent = rand(0,80);
                $outfit->discount_datetime_start = Carbon::parse($createdAt)->toDateTimeString();
                $outfit->discount_datetime_end = Carbon::parse($createdAt)->addWeek()->toDateTimeString();
                $outfit->credit = rand(0,1);
                $outfit->purchase_way = $outfit->stock>0?1:0;//1 = nalici bar

                $outfit->update();       
            
            $search[] = Str::slug($outfit->name_en);
            $search[] = Str::slug($outfit->name);
            foreach($outfit->tags as $tag){
                $search[]=$tag->name;
                $search[]=$tag->name_en;
            }
            $outfit->search = implode(", ", $search);//Hemme yygnap bolyan maglumatlary search-a yygnadym, many to many-daky relashinlary belli bir outfit id-a bermek yalnysh bolar sebabi olar calshynyp dur we her gezek tapawut etya diyip pikir etyan
            $outfit->name = implode(", ", $name);
           $outfit->name_en = implode(", ", $name_en);
        //    $outfit->description = implode(", ", $description) . '.';
        //    $outfit->description_en = implode(", ", $description_en) . '.';
           $outfit->slug = Str::slug($outfit->name_en);
           $outfit->update();
           $outfit->values()->sync($values);

            
       });
   }



    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $createdAt = $this->faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now');
        return [
            'name' => null,
            'name_en' => 'null',
            'slug' => "null",
            // 'description' => $this->faker->paragraph(rand(3, 5)),
            'recommended' => rand(0, 1),
            'viewed' => rand(0, 50),
            'liked' => rand(0, 30),
            'created_at' => $createdAt,
            'seller_id' => Seller::inRandomOrder()->first()->id
        ];
    }
}
