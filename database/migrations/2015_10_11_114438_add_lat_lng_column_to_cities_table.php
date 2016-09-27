<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLngColumnToCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cities', function (Blueprint $table)
		{
			$table->float('lat', 10, 6);
			$table->float('lng', 10, 6);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cities', function (Blueprint $table)
		{
			$table->dropColumn('lat')->after('name');
			$table->dropColumn('lng')->after('lat');
		});
	}
}
