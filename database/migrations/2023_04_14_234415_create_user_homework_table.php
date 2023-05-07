<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_homework', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('homework_id');
            $table->char('src');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('homework_id')->references('id')->on('homework')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_homework');
    }
}
