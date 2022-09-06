<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option;
use App\Models\Value;
class OptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $options = [
                ['name' => 'Firma','name_en' => 'Brand', 'sort_order' => 1, 'values' => [
                                                                                        ['name' => 'Adidas', 'name_en' => 'Adidas','sort_order' => 1],
                                                                                        ['name' => 'U.S POLO ASSN', 'name_en' => 'U.S POLO ASSN','sort_order' => 2],
                                                                                        ['name' => 'Puma', 'name_en' => 'Puma','sort_order' => 3],
                                                                                        ['name' => 'Ipekyol', 'name_en' => 'Ipekyol','sort_order' => 4],
                                                                                        ['name' => 'Mawi', 'name_en' => 'Mavi','sort_order' => 5],
                                                                                        ['name' => 'Nike', 'name_en' => 'Nike','sort_order' => 6],
                                                                                        ['name' => 'Guççi', 'name_en' => 'Gucci','sort_order' => 7],
                                                                                        ['name' => 'Prada', 'name_en' => 'Prada','sort_order' => 8],
                                                                                        ['name' => 'Lakoste', 'name_en' => 'Lacoste','sort_order' => 9],
                                                                                        ['name' => 'Defakto', 'name_en' => 'Defacto','sort_order' => 10],
                                                                                        ['name' => 'New Balans', 'name_en' => 'New Balance','sort_order' => 11],
                                                                                        ['name' => 'Koton', 'name_en' => 'Koton','sort_order' => 12],
                                                                                        ['name' => 'Stradiwarius', 'name_en' => 'Stradivarius','sort_order' => 13],
                                                                                        ['name' => 'Louis Vuitton', 'name_en' => 'Louis Vuitton','sort_order' => 14],
                                                                                        ['name' => 'Zara', 'name_en' => 'Zara','sort_order' => 15],
                                                                                        ['name' => 'H&M', 'name_en' => 'H&M','sort_order' => 16],
                                                                                        ['name' => 'Kalvin Klein', 'name_en' => 'Calvin Clein','sort_order' => 17],

                ]],
                ['name' => 'Görnüşi','name_en' => 'Type', 'sort_order' => 2, 'values' => [
                                                                                        ['name' => 'Pižama', 'name_en' => 'pajamas','sort_order' => 5],
                                                                                        ['name' => 'Balak', 'name_en' => 'Pants','sort_order' => 4],
                                                                                        ['name' => 'Fudbolka', 'name_en' => 'T-shirt','sort_order' => 6],
                                                                                        ['name' => 'Rubaşka', 'name_en' => 'shirt','sort_order' => 3],
                                                                                        ['name' => 'Şorty', 'name_en' => 'shirts','sort_order' => 7],
                                                                                        ['name' => 'Köýnek', 'name_en' => 'Dresses','sort_order' => 1],
                                                                                        ['name' => 'Jinsy', 'name_en' => 'Jeans','sort_order' => 2],
                                                                                        ['name' => 'Kowüş', 'name_en' => 'Shoes','sort_order' => 8],
                                                                                        ['name' => 'krasowka', 'name_en' => 'Sneakers','sort_order' => 9],
                                                                                        ['name' => 'žemper', 'name_en' => 'Jumper','sort_order' => 10],
                                                                                        ['name' => 'Kurtka', 'name_en' => 'jacket','sort_order' => 11],
                                                                                        ['name' => 'Palto', 'name_en' => 'Coat','sort_order' => 12],
                                                                                        ['name' => 'Kostýum', 'name_en' => 'Suit','sort_order' => 13],

                                                                                        ]],
                ['name' => 'Ýurt','name_en' => 'country', 'sort_order' => 3, 'values' => [
                                                                                        ['name' => 'ABŞ', 'name_en' => 'USA','sort_order' => 15],
                                                                                        ['name' => 'Kanada', 'name_en' => 'Canada','sort_order' => 4],
                                                                                        ['name' => 'Albaniýa', 'name_en' => 'Albania','sort_order' => 5],
                                                                                        ['name' => 'Estoniýa', 'name_en' => 'Estonia','sort_order' => 6],
                                                                                        ['name' => 'Fransiýa', 'name_en' => 'France','sort_order' => 7],
                                                                                        ['name' => 'Germaniýa', 'name_en' => 'Germany','sort_order' => 8],
                                                                                        ['name' => 'Italiýa', 'name_en' => 'Italy','sort_order' => 9],
                                                                                        ['name' => 'Braziliýa', 'name_en' => 'Brazil','sort_order' => 10],
                                                                                        ['name' => 'Armeniýa', 'name_en' => 'Georgia','sort_order' => 11],
                                                                                        ['name' => 'Awstriýa', 'name_en' => 'Austria','sort_order' => 12],
                                                                                        ['name' => 'Hytaý', 'name_en' => 'China','sort_order' => 1],
                                                                                        ['name' => 'Indiýa', 'name_en' => 'India','sort_order' => 13],
                                                                                        ['name' => 'Malaýziýa', 'name_en' => 'Malaysia','sort_order' => 14],
                                                                                        ['name' => 'Türk', 'name_en' => 'Turkey','sort_order' => 2],
                                                                                        ['name' => 'Azerbaýjan', 'name_en' => 'Azerbaijan','sort_order' => 15],
                                                                                        ['name' => 'Arabystan', 'name_en' => 'Arab Emirates','sort_order' => 3],
                ]],
                ['name' => 'Jyns','name_en' => 'Gender', 'sort_order' => 4, 'values' => [
                                                                                        ['name' => 'Aýal', 'name_en' => 'Female','sort_order' => 1],
                                                                                        ['name' => 'Erkek', 'name_en' => 'Male','sort_order' => 2],
                                                                                        ['name' => 'Uniseks', 'name_en' => 'Unisex','sort_order' => 3],                                                                                        
                ]],
                ['name' => 'Materiýal','name_en' => 'Material', 'sort_order' => 5, 'values' => [
                                                                                        ['name' => 'Ýüpek', 'name_en' => 'Silk','sort_order' => 1],
                                                                                        ['name' => 'Jinsowy', 'name_en' => 'Denim','sort_order' => 2],
                                                                                        ['name' => 'Atlas', 'name_en' => 'Satin','sort_order' => 3],
                                                                                        ['name' => 'Şifon', 'name_en' => 'Chiffon','sort_order' => 4],
                                                                                        ['name' => 'Meh', 'name_en' => 'Fur','sort_order' => 5],
                                                                                        ['name' => 'Koza', 'name_en' => 'Leather','sort_order' => 6],                                                        
                                                                                        ['name' => 'Barhat', 'name_en' => 'Velvet','sort_order' => 7],                                                         
                                                                                        ['name' => 'ýüň', 'name_en' => 'wool','sort_order' => 8],                                                        
                                                                                        ['name' => 'Sintetika', 'name_en' => 'Synthetic','sort_order' => 9],
                                                                                        ['name' => 'Pagta', 'name_en' => 'Cotton','sort_order' => 10],                                                         
                ]],
                ['name' => 'Ýyly','name_en' => 'Year', 'sort_order' => 6, 'values' => [
                                                                                        ['name' => '2010', 'name_en' => '2010','sort_order' => 13],
                                                                                        ['name' => '2011', 'name_en' => '2011','sort_order' => 12],
                                                                                        ['name' => '2012', 'name_en' => '2012','sort_order' => 11],
                                                                                        ['name' => '2013', 'name_en' => '2013','sort_order' => 10],
                                                                                        ['name' => '2014', 'name_en' => '2014','sort_order' => 9],
                                                                                        ['name' => '2015', 'name_en' => '2015','sort_order' => 8],
                                                                                        ['name' => '2016', 'name_en' => '2016','sort_order' => 7],
                                                                                        ['name' => '2017', 'name_en' => '2017','sort_order' => 6],
                                                                                        ['name' => '2018', 'name_en' => '2018','sort_order' => 5],
                                                                                        ['name' => '2019', 'name_en' => '2019','sort_order' => 4],
                                                                                        ['name' => '2020', 'name_en' => '2020','sort_order' => 3],
                                                                                        ['name' => '2021', 'name_en' => '2021','sort_order' => 2],
                                                                                        ['name' => '2022', 'name_en' => '2022','sort_order' => 1],
                                        
                                                                                        
                ]],
            ];
    
            foreach ($options as $option) {
                $opt = new Option();
                $opt->name = $option['name'];
                $opt->name_en = $option['name_en'];
                $opt->sort_order = $option['sort_order'];
                $opt->save();
    
                foreach ($option['values'] as $value) {
                    $val = new Value();
                    $val->option_id = $opt->id;
                    $val->name = $value['name'];
                    $val->name_en = $value['name_en'];
                    $val->sort_order = $value['sort_order'];
                    $val->save();
                }
            }
        }
    }
}
