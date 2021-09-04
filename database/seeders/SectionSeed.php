<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSection;
use Faker;
use App\Services\TranslitService;

class SectionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1,25) as $item) {
            $section = new ProductSection();
            $name = $faker->text(20);
            $section->name = $name;
            $section->alias = TranslitService::convert($name);
            $section->description = $faker->text(200);
            $section->image = $faker->imageUrl;
            $section->save();
        }
    }
}
