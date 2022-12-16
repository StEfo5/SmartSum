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
            $table->integer('dormitory')->default(0);
            $table->integer('city')->default(0);
            $table->integer('breakfast')->default(0);
            $table->integer('dinner')->default(0);
            $table->integer('entree')->default(0);
            $table->integer('second_course')->default(0);
            $table->date('date');
            $table->integer('class_id');
            $table->boolean('is_confirmed')->default(false);
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
