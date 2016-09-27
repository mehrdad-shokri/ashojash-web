<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionVenuePivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collection_venue', function (Blueprint $table)
		{
			$table->integer('venue_id')->unsigned();
			$table->integer('collection_id')->unsigned();
			$table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade')->onUpdate('cascade');
			$table->primary(array('venue_id', 'collection_id'));
			$table->index('venue_id');
			$table->index('collection_id');
			$table->date('starts_at');
			$table->date('ends_at');
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
		Schema::drop('collection_venue');
	}
}
