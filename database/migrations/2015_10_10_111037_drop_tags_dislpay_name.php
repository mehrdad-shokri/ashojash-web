<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class DropTagsDislpayName extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('tags', function (Blueprint $table)
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
			Schema::table('tags', function (Blueprint $table)
			{
				$table->string('display_name')->unique();
			});
		}
	}
