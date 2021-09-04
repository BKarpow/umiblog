<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use App\Models\Article;
use App\Services\ArticleService;

class ArticleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $service = new ArticleService;
        foreach(range(1, 50) as $item) {
            $title = $faker->text(150);
            $content = $faker->text ."<br><img src=\"".$faker->imageUrl(400, 400)."\"><br>".$faker->text(10000);
            Article::insert([
                'author_id' => 1,
                'title' => $title,
                'url' => $service->translit($title),
                'short_content' => $faker->text,
                'content' => $content,
                'tags' => '["faker", "fake"]',
                'public' => 1,
                'image' => $faker->imageUrl(500, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
