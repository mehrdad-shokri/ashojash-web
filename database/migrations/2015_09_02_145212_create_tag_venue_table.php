<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagVenueTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_venue', function (Blueprint $table) {
			$table->integer('venue_id')->unsigned();
			$table->integer('tag_id')->unsigned();

			$table->foreign('venue_id')->references('id')->on('venues')
				->onDelete('cascade');
			$table->foreign('tag_id')->references('id')
				->on('tags')->onDelete('cascade');
			$table->primary(array('venue_id', 'tag_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tag_venue');
	}
}
