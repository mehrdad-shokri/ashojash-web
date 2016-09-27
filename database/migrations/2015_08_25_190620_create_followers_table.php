<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFollowersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('follows', function (Blueprint $table) {
			$table->integer('follower_id')->unsigned();
			$table->integer('followed_id')->unsigned();
			$table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');
			$table->primary(array('follower_id', 'followed_id'));
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
		Schema::drop('follows');
	}
}
