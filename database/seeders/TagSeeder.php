<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ['Gysh üçin', 'for winter'],
            ['Tomus üçin', 'for Summer'],
            ['Ýaz üçin', 'for Autumn'],
            ['Güýz üçin', 'for Spring'],
            ['Sport üçin', 'for sports'],
            ['Howly üçin', 'for outdoor'],
            ['Mekdep üçin', 'for school'],
            ['Iş üçin', 'for work'],
            ['Öýde geýmäne', 'for home'],
            ['Toý üçin', 'for wedding'],
            ['Dynç üçin', 'for relax'],
            ['Pläž üçin', 'for beach'],

        ];

        foreach ($tags as $tag) {
            $obj = new Tag();
            $obj->name = $tag[0];
            $obj->name_en = $tag[1];
            $obj->save();
        }
    }
}
