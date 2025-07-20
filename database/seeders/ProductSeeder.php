<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("products")->insert([
            ["name"=>"Крила баффало","part_id"=>1, "unit"=>"pcs", "weight_per_piece"=>0.25 ],
            ["name"=>"Крила спайсі","part_id"=>1, "unit"=>"pcs", "weight_per_piece"=>0.3 ],
            ["name"=>"Філе піца", "part_id"=>2, "unit"=>"kg", "weight_per_piece"=>NULL],
            ["name"=>"Філе цезар", "part_id"=>2, "unit"=>"kg", "weight_per_piece"=>NULL],
            ["name"=>"Шия стайк", "part_id"=>3, "unit"=>"pcs", "weight_per_piece"=>0.33 ],
            ["name"=>"Шашлик", "part_id"=>3, "unit"=>"kg", "weight_per_piece"=>NULL ],
            ["name"=>"T-bone стейк","part_id"=>4, "unit"=>"pcs", "weight_per_piece"=>0.35 ],
            ["name"=>"Обрізь","part_id"=>NULL, "unit"=>"kg", "weight_per_piece"=>NULL ],
            ["name"=>"Втрати","part_id"=>NULL, "unit"=>"kg", "weight_per_piece"=>NULL ],

        ]);
    }
}
