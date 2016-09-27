<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScheculesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedules', function (Blueprint $table) {
			$table->increments('id');
			$table->time('opening_at');
			$table->time('closing_at');
			$table->integer('venue_id')->unsigned();
			$table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
			$table->tinyInteger('day');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedules');
	}
}
