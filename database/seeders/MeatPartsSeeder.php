<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeatPartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("meat_parts")->insert([
            ['meat_type_id'=>'1', 'name'=>'Крила'],
            ['meat_type_id'=>'1', 'name'=>'Філе'],
            ['meat_type_id'=>'2', 'name'=>'Шия'],
            ['meat_type_id'=>'2', 'name'=>'Чалогач'],
        ]);
    }
}
