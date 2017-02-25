<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->boolean('read')->default(0);
            $table->boolean('delete')->default(0);
            $table->unsignedInteger('from_teacher_id')->nullable();
            $table->unsignedInteger('from_student_id')->nullable();
            $table->unsignedInteger('to_teacher_id')->nullable();
            $table->unsignedInteger('to_student_id')->nullable();
            $table->foreign('from_teacher_id')->references('id')->on('teachers')->onDelete('set null');
            $table->foreign('from_student_id')->references('id')->on('students')->onDelete('set null');
            $table->foreign('to_teacher_id')->references('id')->on('teachers')->onDelete('set null');
            $table->foreign('to_student_id')->references('id')->on('students')->onDelete('set null');
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
        Schema::dropIfExists('messages');
    }
}
