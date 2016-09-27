<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collections', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->integer('price')->unsigned()->default('0');
			$table->tinyInteger('type')->unsigned();
			$table->tinyInteger('order')->unsigned();
			$table->integer('icon_id')->unsigned()->nullable();
			$table->foreign('icon_id')->references('id')->on('photos')->onDelete('set null')->onUpdate('cascade');
			$table->integer('city_id')->unsigned()->nullable();
			$table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade');
			$table->string('slug');
			$table->tinyInteger('active')->unsigned()->default(0);
			$table->tinyInteger('show_content')->unsigned()->default(1);
			$table->date('starts_at');
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
		Schema::drop('collections');
	}
}
