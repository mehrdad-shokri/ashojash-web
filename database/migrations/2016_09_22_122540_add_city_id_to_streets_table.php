<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityIdToStreetsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('streets', function (Blueprint $table) {
            if (Schema::hasTable('streets')) {
                $table->integer('city_id')->unsigned()->nullable();
                $table->foreign('city_id')->references('id')->on('cities')->onChange('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('streets', function (Blueprint $table) {
            if (Schema::hasTable('streets') && Schema::hasColumn('streets', 'city_id')) {
                $table->dropForeign('streets_city_id_foreign');
                $table->dropColumn('city_id');
            }
        });
    }
}
