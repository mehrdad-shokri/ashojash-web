<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class AddStatusFieldToCities extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('cities', function (Blueprint $table)
			{
				$table->tinyInteger('status')->default(0)->after('slug');
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
				$table->dropColumn('status');
			});
		}
	}
