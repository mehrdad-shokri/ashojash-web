<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class ModifyCuisinesTable extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('cuisines', function (Blueprint $table)
			{
				$table->dropColumn('display_motto');
				$table->integer('image_id')->unsigned()->nullable();
				$table->foreign('image_id')->references('id')->on('photos')->onDelete('set null');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::table('cuisines', function (Blueprint $table)
			{
				$table->string('display_motto');
				$table->dropForeign('images_image_id_foreign');
				$table->dropColumn('image_id');

			});
		}
	}
