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
    { {
            $options = [
                ['name' => 'Firma', 'name_en' => 'Brand', 'sort_order' => 1, 'values' => [
                    ['name' => 'Adidas', 'name_en' => 'Adidas', 'sort_order' => 1],
                    ['name' => 'U.S POLO ASSN', 'name_en' => 'U.S POLO ASSN', 'sort_order' => 2],
                    ['name' => 'Puma', 'name_en' => 'Puma', 'sort_order' => 3],
                    ['name' => 'Ipekyol', 'name_en' => 'Ipekyol', 'sort_order' => 4],
                    ['name' => 'Mawi', 'name_en' => 'Mavi', 'sort_order' => 5],
                    ['name' => 'Nike', 'name_en' => 'Nike', 'sort_order' => 6],
                    ['name' => 'Guççi', 'name_en' => 'Gucci', 'sort_order' => 7],
                    ['name' => 'Prada', 'name_en' => 'Prada', 'sort_order' => 8],
                    ['name' => 'Lakoste', 'name_en' => 'Lacoste', 'sort_order' => 9],
                    ['name' => 'Defakto', 'name_en' => 'Defacto', 'sort_order' => 10],
                    ['name' => 'New Balans', 'name_en' => 'New Balance', 'sort_order' => 11],
                    ['name' => 'Koton', 'name_en' => 'Koton', 'sort_order' => 12],
                    ['name' => 'Stradiwarius', 'name_en' => 'Stradivarius', 'sort_order' => 13],
                    ['name' => 'Louis Vuitton', 'name_en' => 'Louis Vuitton', 'sort_order' => 14],
                    ['name' => 'Zara', 'name_en' => 'Zara', 'sort_order' => 15],
                    ['name' => 'H&M', 'name_en' => 'H&M', 'sort_order' => 16],
                    ['name' => 'Kalvin Klein', 'name_en' => 'Calvin Clein', 'sort_order' => 17],

                ]],
                // ['name' => 'Görnüşi','name_en' => 'Type', 'sort_order' => 2, 'values' => [
                //                                                                         ['name' => 'Pižama', 'name_en' => 'pajamas','sort_order' => 5],
                //                                                                         ['name' => 'Balak', 'name_en' => 'Pants','sort_order' => 4],
                //                                                                         ['name' => 'Fudbolka', 'name_en' => 'T-shirt','sort_order' => 6],
                //                                                                         ['name' => 'Rubaşka', 'name_en' => 'shirt','sort_order' => 3],
                //                                                                         ['name' => 'Şorty', 'name_en' => 'shirts','sort_order' => 7],
                //                                                                         ['name' => 'Köýnek', 'name_en' => 'Dresses','sort_order' => 1],
                //                                                                         ['name' => 'Jinsy', 'name_en' => 'Jeans','sort_order' => 2],
                //                                                                         ['name' => 'Kowüş', 'name_en' => 'Shoes','sort_order' => 8],
                //                                                                         ['name' => 'krasowka', 'name_en' => 'Sneakers','sort_order' => 9],
                //                                                                         ['name' => 'žemper', 'name_en' => 'Jumper','sort_order' => 10],
                //                                                                         ['name' => 'Kurtka', 'name_en' => 'jacket','sort_order' => 11],
                //                                                                         ['name' => 'Palto', 'name_en' => 'Coat','sort_order' => 12],
                //                                                                         ['name' => 'Kostýum', 'name_en' => 'Suit','sort_order' => 13],

                //                                                                         ]],
                ['name' => 'Ýurt', 'name_en' => 'Country', 'sort_order' => 3, 'values' => [
                    ['name' => 'ABŞ', 'name_en' => 'USA', 'sort_order' => 15],
                    ['name' => 'Kanada', 'name_en' => 'Canada', 'sort_order' => 4],
                    ['name' => 'Albaniýa', 'name_en' => 'Albania', 'sort_order' => 5],
                    ['name' => 'Estoniýa', 'name_en' => 'Estonia', 'sort_order' => 6],
                    ['name' => 'Fransiýa', 'name_en' => 'France', 'sort_order' => 7],
                    ['name' => 'Germaniýa', 'name_en' => 'Germany', 'sort_order' => 8],
                    ['name' => 'Italiýa', 'name_en' => 'Italy', 'sort_order' => 9],
                    ['name' => 'Braziliýa', 'name_en' => 'Brazil', 'sort_order' => 10],
                    ['name' => 'Armeniýa', 'name_en' => 'Georgia', 'sort_order' => 11],
                    ['name' => 'Awstriýa', 'name_en' => 'Austria', 'sort_order' => 12],
                    ['name' => 'Hytaý', 'name_en' => 'China', 'sort_order' => 1],
                    ['name' => 'Indiýa', 'name_en' => 'India', 'sort_order' => 13],
                    ['name' => 'Malaýziýa', 'name_en' => 'Malaysia', 'sort_order' => 14],
                    ['name' => 'Türk', 'name_en' => 'Turkey', 'sort_order' => 2],
                    ['name' => 'Azerbaýjan', 'name_en' => 'Azerbaijan', 'sort_order' => 15],
                    ['name' => 'Arabystan', 'name_en' => 'Arab Emirates', 'sort_order' => 3],
                ]],
                ['name' => 'Jyns', 'name_en' => 'Gender', 'sort_order' => 4, 'values' => [
                    ['name' => 'Aýal', 'name_en' => 'Female', 'sort_order' => 1],
                    ['name' => 'Erkek', 'name_en' => 'Male', 'sort_order' => 2],
                    ['name' => 'Uniseks', 'name_en' => 'Unisex', 'sort_order' => 3],
                ]],
                ['name' => 'Materiýal', 'name_en' => 'Material', 'sort_order' => 5, 'values' => [
                    ['name' => 'Ýüpek', 'name_en' => 'Silk', 'sort_order' => 1],
                    ['name' => 'Jinsowy', 'name_en' => 'Denim', 'sort_order' => 2],
                    ['name' => 'Atlas', 'name_en' => 'Satin', 'sort_order' => 3],
                    ['name' => 'Şifon', 'name_en' => 'Chiffon', 'sort_order' => 4],
                    ['name' => 'Meh', 'name_en' => 'Fur', 'sort_order' => 5],
                    ['name' => 'Koza', 'name_en' => 'Leather', 'sort_order' => 6],
                    ['name' => 'Barhat', 'name_en' => 'Velvet', 'sort_order' => 7],
                    ['name' => 'ýüň', 'name_en' => 'wool', 'sort_order' => 8],
                    ['name' => 'Sintetika', 'name_en' => 'Synthetic', 'sort_order' => 9],
                    ['name' => 'Pagta', 'name_en' => 'Cotton', 'sort_order' => 10],
                ]],
                ['name' => 'Ýyly', 'name_en' => 'Year', 'sort_order' => 6, 'values' => [
                    ['name' => '2010', 'name_en' => '2010', 'sort_order' => 13],
                    ['name' => '2011', 'name_en' => '2011', 'sort_order' => 12],
                    ['name' => '2012', 'name_en' => '2012', 'sort_order' => 11],
                    ['name' => '2013', 'name_en' => '2013', 'sort_order' => 10],
                    ['name' => '2014', 'name_en' => '2014', 'sort_order' => 9],
                    ['name' => '2015', 'name_en' => '2015', 'sort_order' => 8],
                    ['name' => '2016', 'name_en' => '2016', 'sort_order' => 7],
                    ['name' => '2017', 'name_en' => '2017', 'sort_order' => 6],
                    ['name' => '2018', 'name_en' => '2018', 'sort_order' => 5],
                    ['name' => '2019', 'name_en' => '2019', 'sort_order' => 4],
                    ['name' => '2020', 'name_en' => '2020', 'sort_order' => 3],
                    ['name' => '2021', 'name_en' => '2021', 'sort_order' => 2],
                    ['name' => '2022', 'name_en' => '2022', 'sort_order' => 1],


                ]],
                ['name' => 'Ekran razmery', 'name_en' => 'Screen size', 'sort_order' => 1, 'values' => [
                    ['name' => '11.6"', 'name_en' => '11.6"', 'sort_order' => 1],
                    ['name' => '12.3"', 'name_en' => '12.3"', 'sort_order' => 2],
                    ['name' => '13.3"', 'name_en' => '13.3"', 'sort_order' => 3],
                    ['name' => '14"', 'name_en' => '14"', 'sort_order' => 4],
                    ['name' => '15.6"', 'name_en' => '15.6"', 'sort_order' => 5],
                    ['name' => '17.3"', 'name_en' => '17.3"', 'sort_order' => 6],
                ]],
                ['name' => 'Displey gornushi', 'name_en' => 'Display resolution', 'sort_order' => 2, 'values' => [
                    ['name' => '1366x768', 'name_en' => '1366x768', 'sort_order' => 1],
                    ['name' => '1920x1080', 'name_en' => '1920x1080', 'sort_order' => 2],
                    ['name' => '2560x1600', 'name_en' => '2560x1600', 'sort_order' => 3],
                    ['name' => '2736x1824', 'name_en' => '2736x1824', 'sort_order' => 4],
                ]],
                ['name' => 'Prosessor', 'name_en' => 'Processor', 'sort_order' => 3, 'values' => [
                    ['name' => 'Apple M1', 'name_en' => 'Apple M1', 'sort_order' => 1],
                    ['name' => 'Intel Celeron', 'name_en' => 'Intel Celeron', 'sort_order' => 2],
                    ['name' => 'Intel Core i3', 'name_en' => 'Intel Core i3', 'sort_order' => 3],
                    ['name' => 'Intel Core i5', 'name_en' => 'Intel Core i5', 'sort_order' => 4],
                    ['name' => 'Intel Core i7', 'name_en' => 'Intel Core i7', 'sort_order' => 5],
                    ['name' => 'Intel Pentium', 'name_en' => 'Intel Pentium', 'sort_order' => 6],
                    ['name' => 'AMD RYZEN 3', 'name_en' => 'AMD RYZEN 3', 'sort_order' => 7],
                    ['name' => 'AMD RYZEN 5', 'name_en' => 'AMD RYZEN 5', 'sort_order' => 8],
                    ['name' => 'AMD RYZEN 7', 'name_en' => 'AMD RYZEN 7', 'sort_order' => 9],
                    ['name' => 'AMD RYZEN 9', 'name_en' => 'AMD RYZEN 9', 'sort_order' => 10],
                ]],
                ['name' => 'Ram', 'name_en' => 'RAM', 'sort_order' => 4, 'values' => [
                    ['name' => '4 GB', 'name_en' => '4 GB', 'sort_order' => 1],
                    ['name' => '8 GB', 'name_en' => '8 GB', 'sort_order' => 2],
                    ['name' => '16 GB', 'name_en' => '16 GB', 'sort_order' => 3],
                ]],
                ['name' => 'Grafika guyji', 'name_en' => 'Graphics memory', 'sort_order' => 5, 'values' => [
                    ['name' => '2 GB', 'name_en' => '2 GB', 'sort_order' => 1],
                    ['name' => '4 GB', 'name_en' => '4 GB', 'sort_order' => 2],
                    ['name' => '6 GB', 'name_en' => '6 GB', 'sort_order' => 3],
                ]],
                ['name' => 'Disk gowrumi', 'name_en' => 'Storage capacity', 'sort_order' => 7, 'values' => [
                    ['name' => '128 GB', 'name_en' => '128 GB', 'sort_order' => 1],
                    ['name' => '256 GB', 'name_en' => '256 GB', 'sort_order' => 2],
                    ['name' => '512 GB', 'name_en' => '512 GB', 'sort_order' => 3],
                    ['name' => '1 TB', 'name_en' => '1 TB', 'sort_order' => 4],
                ]],
                ['name' => 'Garantiya', 'name_en' => 'Warranty (month)', 'sort_order' => 8, 'values' => [
                    ['name' => '1', 'name_en' => '1', 'sort_order' => 1],
                    ['name' => '3', 'name_en' => '3', 'sort_order' => 2],
                    ['name' => '6', 'name_en' => '6', 'sort_order' => 3],
                    ['name' => '12', 'name_en' => '12', 'sort_order' => 4],
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
