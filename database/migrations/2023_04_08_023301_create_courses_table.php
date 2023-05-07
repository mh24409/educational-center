<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('details');
            $table->integer('subject_id');
            $table->char('image')->default('default.png');
            $table->integer('no_of_students');
            $table->integer('no_of_avilables');
            $table->enum('firstday', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'saturday', 'friday']);
            $table->enum('firstdaytime', ['first', 'second', 'third', 'fourth']);
            $table->enum('secondday', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'saturday', 'friday'])->nullable();
            $table->enum('seconddaytime', ['first', 'second', 'third', 'fourth'])->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
