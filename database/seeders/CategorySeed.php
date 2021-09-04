<?php

namespace Database\Seeders;

use App\Services\TranslitService;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\ProductSection;
use Faker;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $sections = ProductSection::all();
        foreach ($sections as $s) {
            foreach (range(1,25) as $item) {
                $section = new ProductCategory();
                $name = $faker->text(20);
                $section->name = $name;
                $section->alias = TranslitService::convert($name);
                $section->description = $faker->text(200);
                $section->image = $faker->imageUrl;
                $section->section_id = $s->id;
                $section->save();
            }
        }

    }
}
