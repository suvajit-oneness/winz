<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ["name"=>"Movies","slug" => 'movies',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Shows","slug" => 'shows',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Web Series","slug" => 'web-series',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
        ]);
    }
}
