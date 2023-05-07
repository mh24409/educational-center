<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('course_id');
            $table->enum('firstday', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'saturday', 'friday']);
            $table->enum('firstdaytime', ['first', 'second', 'third', 'fourth']);
            $table->enum('secondday', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'saturday', 'friday']);
            $table->enum('seconddaytime', ['first', 'second', 'third', 'fourth']);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('attendance_number')->default('0');
            $table->integer('absence_number')->default('0');
            $table->date('last_attend')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('user_courses');
    }
}
