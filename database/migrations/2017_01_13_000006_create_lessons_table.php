<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type')->default(1);
            $table->boolean('comment')->default(1);
            $table->string('title');
            $table->text('board')->nullable();
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->text('text_content')->nullable();
            $table->text('video_content')->nullable();
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('course_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
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
        Schema::dropIfExists('lessons');
    }
}
