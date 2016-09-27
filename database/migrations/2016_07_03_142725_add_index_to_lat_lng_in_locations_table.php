<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToLatLngInLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('locations', function (Blueprint $table)
		{
			$table->index('lat');
			$table->index('lng');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('locations', function (Blueprint $table)
		{
			$table->dropIndex('locations_lat_index');
			$table->dropIndex('locations_lng_index');
		});
	}
}
