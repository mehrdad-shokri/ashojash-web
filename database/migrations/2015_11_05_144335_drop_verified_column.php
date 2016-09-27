<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class DropVerifiedColumn extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('users', function (Blueprint $table)
			{
				$table->dropColumn('verified');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::table('users', function (Blueprint $table)
			{
				$table->tinyInteger("verified")->after('phone');
			});
		}
	}
