<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInstagramSiteUrlToVenues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->string('instagram')->nullable()->after('image_id');
            $table->string('url')->nullable()->after('instagram');
            $table->string('phone')->nullable()->after('url');
            $table->string('mobile')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn(['instagram', 'url', 'phone']);
        });
    }
}
