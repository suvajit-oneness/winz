<?php

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::insert([
            ["name"=>"Action","slug" => 'action',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Adventure","slug" => 'adventure',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Classics","slug" => 'classics',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Thriller","slug" => 'thriller',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Romance","slug" => 'romance',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Drama","slug" => 'drama',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],

        ]);
    }
}
