<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateGoogleOauthTable extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('google_oauth', function (Blueprint $table)
			{
				$table->increments('id');
				$table->integer('user_id')->unsigned();
				$table->foreign('user_id')->references("id")->on('users')->onDelete("cascade");
				$table->string("token");
				$table->string("name");
				$table->string('email')->unique();
				$table->integer("circled_by_count")->unsigned();
				$table->string("lang");
				$table->string("avatar");
				$table->tinyInteger("min_range");
				$table->tinyInteger("max_range");
				$table->string("etag");
				$table->string('url');
				$table->string('social_id');
				$table->tinyInteger("is_plus_user");
				$table->tinyInteger('verified');
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
			Schema::drop('google_oauth');
		}
	}
