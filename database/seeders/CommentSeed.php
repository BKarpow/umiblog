<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use App\Models\Article;
use App\Models\Comment;

class CommentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::all();
        $faker = Faker\Factory::create();
        if ($articles) {
            foreach($articles as $article) {
                if ($article->id) {
                    foreach(range(1, 200) as $item) {
                        Comment::insert([
                            'comment' => $faker->text,
                            'article_id' => $article->id,
                            'user_id' => 1,
                            'moderate' => 1,
                        ]);
                    }
                }
            }
        }
    }
}
