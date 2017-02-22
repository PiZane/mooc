<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->boolean('top')->default(0);
            $table->unsignedInteger('reply_id')->nullable();
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('lesson_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('CASCADE');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('CASCADE');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('CASCADE');
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
        Schema::dropIfExists('comments');
    }
}
