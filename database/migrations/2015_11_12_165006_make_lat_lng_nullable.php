<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class MakeLatLngNullable extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('locations', function (Blueprint $table)
			{
				$table->float('lat', 10, 6)->nullable()->change();
				$table->float('lng', 10, 6)->nullable()->change();
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
				$table->float('lat', 10, 6)->change();
				$table->float('lat', 10, 6)->change();
			});
		}
	}
