<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('alias');
            $table->unsignedBigInteger('category_id');
            $table->integer('price');
            $table->string('currency', 10);
            $table->integer('views')->default(0);
            $table->integer('rating')->default(0);
            $table->json('images');
            $table->json('sizes')->nullable();
            $table->json('params')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description');
            $table->boolean('public')->default(true);
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
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
        Schema::dropIfExists('products');
    }
}
