<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeLatLngToShape extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('locations', function (Blueprint $table)
		{
			$tableName = 'locations';
			$pointColumn = 'geolocation';
			$indexName = 'sx_locations_geolocation';
			$lng='lng';
			DB::statement("Alter TABLE $tableName ADD COLUMN $pointColumn POINT AFTER $lng");
			DB::statement("UPDATE  $tableName SET $pointColumn = POINT($tableName.lng,$tableName.lat)");
			DB::statement("UPDATE $tableName set geolocation = ST_GeomFromText(st_astext(geolocation),0)");
			if(Schema::hasTable('streets'))
			{
				DB::statement("UPDATE streets set shape = ST_GeomFromText(st_astext(shape),0)");
			}
			DB::statement("ALTER TABLE $tableName MODIFY  $pointColumn POINT NOT NULL");
			DB::statement("CREATE SPATIAL INDEX $indexName ON $tableName($pointColumn)");
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
			$pointColumn = 'geolocation';
			$indexName = 'sx_locations_geolocation';
			$table->dropColumn($pointColumn);
			$table->dropIndex($indexName);
		});
	}
}
