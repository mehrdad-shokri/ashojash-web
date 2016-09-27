<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class AddStatusFieldToReviews extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('reviews', function (Blueprint $table)
			{
				$table->tinyInteger("status")->default(1)->after("decor");
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::table('reviews', function (Blueprint $table)
			{
				$table->dropColumn("status");
			});
		}
	}
