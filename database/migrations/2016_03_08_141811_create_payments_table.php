<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function (Blueprint $table)
		{
			$table->increments('id');
//			$table->string('merchant_id', 100);
			$table->string('authority');
			$table->string('ref_id')->nullable();
			$table->integer('amount');
			$table->integer('venue_id')->unsigned();
			$table->foreign('venue_id')->references('id')->on('venues');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payments');
	}
}
