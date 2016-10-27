<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDatetimeFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('locations', function (Blueprint $table)
		{
			$createdAt = 'created_at';
			$updatedAt = 'updated_at';
			DB::statement("ALTER table locations CHANGE $createdAt  $createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
			DB::statement("ALTER table locations CHANGE $updatedAt  $updatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
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
			//
		});
	}
}
