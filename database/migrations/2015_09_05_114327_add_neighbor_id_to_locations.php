<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNeighborIdToLocations extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('locations', function (Blueprint $table) {
			$table->integer('neighbor_id')->unsigned()->after('venue_id')->nullable();
			$table->foreign('neighbor_id')->references('id')->on('neighbors')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('locations', function (Blueprint $table) {
			$table->dropColumn('neighbor_id');
		});
	}
}
