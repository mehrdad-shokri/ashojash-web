<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;

	class CreateVenuesTable extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('venues', function (Blueprint $table)
			{
				$table->increments('id');
				$table->string('name');
				$table->integer('vendor_id')->unsigned()->nullable();
				$table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
				$table->string('slug');
				$table->tinyInteger('status');
				$table->decimal('score', 2, 1);
//				$table->tinyInteger('score')->unsigned();
				$table->tinyInteger('cost')->unsigned();
				$table->integer("owner_id")->unsigned()->nullable();
				$table->foreign('owner_id')->references("id")->on("users")->onDelete("set null");
				$table->integer('image_id')->unsigned()->nullable();
				$table->foreign('image_id')->references('id')->on('photos')->onDelete('set null');
				$table->tinyInteger('type')->unsigned();
				$table->timestamp('starts_at')->before('valid_until')->useCurrent();
				$table->timestamp('valid_until')->useCurrent();
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
			Schema::drop('venues');
		}
	}
