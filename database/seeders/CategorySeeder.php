<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories =
            [
                [
                    'name' => 'eshik', 'name_en' => 'clothes', 'options' => ['Country', 'Gender', 'Material'], 'children' => [
                        [
                            'name' => 'balak', 'name_en' => 'trouser', 'options' => ['Country', 'Gender', 'Material', 'Year']
                        ],
                        [
                            'name' => 'fudbolka', 'name_en' => 't-shirt', 'options' => ['Country', 'Gender', 'Material', 'Brand']
                        ]
                    ]
                ],
                ['name' => 'electronika', 'name_en' => 'electronics', 'options' => ['Country', 'Year', 'Brand'], 'children' => [
                    ['name' => 'kompyuter', 'name_en' => 'computer', 'options' => ['Country', 'Year', 'Brand', 'RAM', 'Processor', 'Display resolution'],],
                    ['name' => 'oy tehnika', 'name_en' => 'technics for home', 'options' => ['Country', 'Year', 'Brand'], 'children'=>[
                        ['name'=>'plesos', 'name_en'=>'vacuum', 'options'=>['Year', 'Brand']]
                    ]]
                ]]
            ];
            foreach ($categories as  $category) {
                CategorySeeder::seedwithchildren($category, null);
            }
        }

        public static function seedwithchildren(Array $array, $parent_id){
            $category = new Category();
            $category->name = $array['name'];
            $category->name_en = $array['name_en'];
            if ($parent_id) {
                $category->category_id = $parent_id;
            }
            $category->save();
            echo($category->name . 'saved');
            if (isset($array['options'])) {
                foreach ($array['options'] as $option) {
                    $find = Option::where('name_en', $option)->first();
                    $category->options()->attach($find->id);
                    $category->update();
                }
            }
            echo('Options attached');
            if (isset($array['children'])) {
                echo('making children process started giving them parent as - ' . $category->id );
                foreach ($array['children'] as $child) {
                    CategorySeeder::seedwithchildren($child, $category->id);
                }
            }
        }
}
