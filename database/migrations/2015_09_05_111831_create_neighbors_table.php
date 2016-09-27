<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNeighborsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neighbors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
			$table->string('display_name')->unique();
			$table->integer('city_id')->unsigned();
			$table->integer('country_id')->unsigned();
			$table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
			$table->foreign('country_id')->references('id')->on('cities')->onDelete('cascade');
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
        Schema::drop('neighbors');
    }
}
