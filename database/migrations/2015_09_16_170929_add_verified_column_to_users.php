<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddVerifiedColumnToUsers extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->rememberToken()->after('password');
			$table->string('email_token')->after('remember_token')->nullable();
			$table->tinyInteger('verified')->default(0)->after('remember_token');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('verified');
			$table->dropColumn('email_token');
			$table->dropRememberToken();
		});
	}
}
