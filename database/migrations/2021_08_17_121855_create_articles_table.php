<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');

            $table->string('title');
            $table->string('url')->nullable();
            $table->text('short_content')->nullable();
            $table->text('content');
            $table->json('tags');
            $table->string('source_main')->nullable();
            $table->string('source_1')->nullable();
            $table->string('source_2')->nullable();
            $table->string('source_3')->nullable();
            $table->text('source_other')->nullable();
            $table->boolean('public')->default(false);
            $table->boolean('main')->default(false);
            $table->boolean('top')->default(false);
            $table->boolean('important')->default(false);
            $table->boolean('red')->default(false);
            $table->boolean('green')->default(false);
            $table->boolean('blue')->default(false);
            $table->boolean('fake')->default(false);
            $table->boolean('doubt')->default(false);

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
