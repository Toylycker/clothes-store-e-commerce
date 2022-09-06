<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            ['Aşgabat şäheri', 'Ashgabat city'],
            ['Ahal welaýaty', 'Akhal region'],
            ['Balkan welaýaty', 'Balkan region'],
            ['Mary welaýaty', 'Mary region'],
            ['Lebap welaýaty', 'Lebap region'],
            ['Daşoguz welaýaty', 'Dashoguz region'],
        ];

        foreach ($locations as $location) {
            $obj = new Location();
            $obj->name = $location[0];
            $obj->name_en = $location[1];
            $obj->save();
        }
    }
}
