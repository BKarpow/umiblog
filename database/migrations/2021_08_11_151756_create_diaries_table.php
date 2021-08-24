<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diaries', function (Blueprint $table) {
            $table->id();
            //full_date,date,weekday,time,mood,activities,note_title,note
            $table->date('full_date');
            $table->string('date');
            $table->string('weekday');
            $table->time('time');
            $table->text('activities');
            $table->string('note_title');
            $table->text('note');

            $table->unsignedBigInteger('mood_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('mood_id')
                ->references('id')
                ->on('moods');

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
        Schema::dropIfExists('diaries');
    }
}
