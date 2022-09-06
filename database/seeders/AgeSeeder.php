<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Age;
class AgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ages = [
            '0-3',
            '3-6',
            '6-9',
            '9-12',
            '12-15',
            'S',
            'XS',
            'M',
            'XM',
            'L',
            'XL',
            'XXL',

        ];

        foreach ($ages as $age) {
            $obj = new Age();
            $obj->name = $age;
            $obj->save();
        }
    }
}
