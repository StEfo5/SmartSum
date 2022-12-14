<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summaries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('dormitory');
            $table->integer('city');
            $table->integer('breakfast');
            $table->integer('dinner');
            $table->integer('entree');
            $table->integer('second_course');
            $table->date('date');
            $table->integer('class_id');
            $table->boolean('is_confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('summaries');
    }
};
