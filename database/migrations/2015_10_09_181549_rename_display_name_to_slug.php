<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class RenameDisplayNameToSlug extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('cities', function (Blueprint $table)
			{
				$table->dropColumn('display_name');
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
				$table->string('display_name')->after('name');
			});
		}
	}
