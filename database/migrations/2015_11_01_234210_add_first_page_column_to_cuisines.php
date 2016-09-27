<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class AddFirstPageColumnToCuisines extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('cuisines', function (Blueprint $table)
			{
				$table->tinyInteger("first_page")->after("motto")->default(0);
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::table('cuisines', function (Blueprint $table)
			{
				$table->dropColumn("first_page");
			});
		}
	}
