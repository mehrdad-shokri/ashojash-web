<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityIdToLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lines', function (Blueprint $table)
		{
			if (Schema::hasTable('lines'))
			{
				$table->integer('city_id')->unsigned()->onUpdate('cascade');
				$table->foreign('city_id')->references('id')->on('cities')->onChange('cascade');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lines', function (Blueprint $table)
		{
			if (Schema::hasTable('lines') && Schema::hasColumn('lines', 'city_id'))
			{
				$table->dropForeign('users_city_id_foreign');
				$table->dropColumn('city_id');
			}
		});
	}
}
