<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class MakeNameColumnUniqueCountriesTable extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('countries', function (Blueprint $table)
			{
				$table->unique('name');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::table('countries', function (Blueprint $table)
			{
				$table->dropUnique('name');
			});
		}
	}
