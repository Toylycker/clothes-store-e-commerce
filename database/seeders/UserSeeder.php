<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [['admin', 'admin', '865000000', 'admin123', 'admin@gmail.com'],
                 ['user', 'user', '865234567', 'user123', 'user@gmail.com']];


        foreach($users as $user){
            $obj = new User();
            $obj->username = $user[0];
            $obj->role = $user[1];
            $obj->phone = $user[2];
            $obj->password = bcrypt($user[3]);
            $obj->mail = $user[4];
            $obj->save();
        }
    }
}