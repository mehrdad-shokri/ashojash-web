<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureVenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_venue', function (Blueprint $table) {
            $table->integer('venue_id')->unsigned();
            $table->integer('feature_id')->unsigned();

            $table->foreign('venue_id')->references('id')->on('venues')
                ->onDelete('cascade');
            $table->foreign('feature_id')->references('id')
                ->on('tags')->onDelete('cascade');
            $table->primary(array('venue_id', 'feature_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feature_venue');
    }
}
