<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCollectionsDatesAndIcons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('collections', function (Blueprint $table)
		{
			$table->dropForeign('collections_icon_id_foreign');
			$table->dropColumn(array('price', 'icon_id', 'show_content'));
			$table->dateTime('starts_at')->change();
			$table->dateTime('ends_at')->after('starts_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('collections', function (Blueprint $table)
		{
			$table->tinyInteger('show_content')->unsigned()->default(1);
			$table->integer('icon_id')->unsigned()->nullable();
			$table->foreign('icon_id')->references('id')->on('photos')->onDelete('set null')->onUpdate('cascade');
			$table->integer('price')->unsigned()->default('0');
			$table->date('starts_at')->change();
			$table->dropColumn('ends_at');
		});
	}
}
