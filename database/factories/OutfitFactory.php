<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Location;
use App\Models\Seller;
use App\Models\Tag;
use App\Models\Age;
use App\Models\Category;
use App\Models\Outfit;
use App\Models\Option;
use App\Models\OutfitItem;
use App\Models\Value;
use App\Models\OutfitSeller;
use App\Models\Variation;
use App\Models\VariationOption;
use Carbon\Carbon;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outfit>
 */
class OutfitFactory extends Factory
{

    public static function attachCategories(Category $category, Outfit $outfit)
    { //recursive function
        // echo($category->name);
        // echo($outfit->name );

        $outfit->categories()->attach($category->id);
        echo ($category->name . 'attached------>');
        $outfit->update();
        if (($category->children->count() > 0)) {
            $justOneChild = $category->children()->inRandomOrder()->first();
            echo ('chosen->' . $justOneChild->name);
            OutfitFactory::attachCategories($justOneChild, $outfit);
        }
    }

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
            echo ('----------------------choosing category------------------------');

            $category = Category::where('category_id', null)->inRandomOrder()->with('children')->first(); // i need attach product to all categories that goes down from parent. So i am grabbing the highest parent and starting attaching it from parent to children taking only one child in each.
            echo ('----------------------chose the category------------------------');

            OutfitFactory::attachCategories($category, $outfit);


            $name = [];
            $name_en = [];
            $description = [];
            $description_en = [];
            $values = [];
            $search = [];

            $options = Option::whereHas('categories', function ($query) use ($outfit) {
                $query->doesntHave('children')->whereHas('outfits', function ($query) use ($outfit) {
                    $query->where('id', $outfit->id);
                });
            })
                ->with(['values'])
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

            $outfit->update();

            $search[] = Str::slug($outfit->name_en);
            $search[] = Str::slug($outfit->name);
            foreach ($outfit->tags as $tag) {
                $search[] = $tag->name;
                $search[] = $tag->name_en;
            }
            $outfit->search = implode(", ", $search); //Hemme yygnap bolyan maglumatlary search-a yygnadym, many to many-daky relashinlary belli bir outfit id-a bermek yalnysh bolar sebabi olar calshynyp dur we her gezek tapawut etya diyip pikir etyan
            $outfit->name = implode(", ", $name);
            $outfit->name_en = implode(", ", $name_en);
            //    $outfit->description = implode(", ", $description) . '.';
            //    $outfit->description_en = implode(", ", $description_en) . '.';
            $outfit->slug = Str::slug($outfit->name_en);
            $outfit->update();
            $outfit->values()->sync($values);
            //    create items for product 

            $rand_variations = rand(4, 6);

            for ($i = 0; $i < $rand_variations; $i++) {
                $rand_variation_options = rand(2, 5);
                $variation = new Variation();
                $variation->outfit_id = $outfit->id;
                $variation->name = $this->faker->word();
                $variation->save();
                echo('variation number-> ' . $i);
                for ($b = 0; $b <= $rand_variation_options; $b++) {
                    VariationOption::create(['option' => $this->faker->word(), 'variation_id' => $variation->id]);
                }
            }



            $rand_item = rand(3, 6);//items should not choose options in each category same as other item, rather in that case just stock number should be increased by 1;
            for ($i = 0; $i < $rand_item; $i++) {
                $item = new OutfitItem();
                $item->outfit_id = $outfit->id;
                $item->price = rand(100, 1000);
                $item->stock = rand(0, 100);
                $item->sold = rand(0, 100);
                $item->discount_percent = rand(0, 80);
                $item->discount_datetime_start = Carbon::parse($createdAt)->toDateTimeString();
                $item->discount_datetime_end = Carbon::parse($createdAt)->addWeek()->toDateTimeString();
                $item->credit = rand(0, 1);
                $item->purchase_way = $item->stock > 0 ? 1 : 0; //1 = nalici bar
                $item->save();
                $variations = Variation::where('outfit_id', $outfit->id)->with('variation_options')->get();
                foreach ($variations as $variation) {
                    $item->variation_options()->attach($variation->variation_options()->inRandomOrder()->first()->id);
                }
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
