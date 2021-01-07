<?php

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::insert([
            ["name"=>"Bengali","slug" => 'bengali',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"Hindi","slug" => 'hindi',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["name"=>"English","slug" => 'english',"status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
        ]);
    }
}
