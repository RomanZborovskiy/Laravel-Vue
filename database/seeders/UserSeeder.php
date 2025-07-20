<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            ['name'=>'Іван','email'=> 'ivan@gmail.com', 'password'=> Hash::make('1234')],
            ['name'=>'Григорій','email'=> 'grisha@gmail.com', 'password'=> Hash::make('1234')],
            ['name'=>'Андрій','email'=> 'andrew@gmail.com', 'password'=> Hash::make('1234')],
        ]);
    }
}
