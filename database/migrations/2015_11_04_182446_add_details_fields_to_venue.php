<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class AddDetailsFieldsToVenue extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('venues', function (Blueprint $table)
			{
				$table->text('details')->nullalbe()->after('mobile');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::table('venues', function (Blueprint $table)
			{
				$table->dropColumn('details');
			});
		}
	}
