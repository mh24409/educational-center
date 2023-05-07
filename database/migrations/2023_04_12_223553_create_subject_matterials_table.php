<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectMatterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_matterials', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id');
            $table->char('name');
            $table->char('details');
            $table->char('src');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_matterials');
    }
}
