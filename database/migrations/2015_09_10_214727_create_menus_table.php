<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('venue_id')->unsigned();
			$table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
			$table->integer('price')->unsigned();
			$table->string('menu_item');
			$table->string('ingredients');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
