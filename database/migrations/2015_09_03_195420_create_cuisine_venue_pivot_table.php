<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCuisineVenuePivotTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cuisine_venue', function (Blueprint $table) {
			$table->integer('venue_id')->unsigned();
			$table->integer('cuisine_id')->unsigned();

			$table->foreign('venue_id')->references('id')->on('venues')
				->onDelete('cascade');
			$table->foreign('cuisine_id')->references('id')
				->on('cuisines')->onDelete('cascade');
			$table->primary(array('venue_id', 'cuisine_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cuisine_venue');
	}
}
