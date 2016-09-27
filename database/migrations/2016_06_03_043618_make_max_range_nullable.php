<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeMaxRangeNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `google_oauth` MODIFY `max_range` SMALLINT UNSIGNED NULL;');
		DB::statement('UPDATE `google_oauth` SET `max_range` = NULL WHERE `max_range` = 0;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `google_oauth` MODIFY `max_range` INTEGER UNSIGNED NOT NULL;');
		DB::statement('ALTER TABLE `google_oauth` MODIFY `max_range` INTEGER UNSIGNED NOT NULL;');
	}
}
