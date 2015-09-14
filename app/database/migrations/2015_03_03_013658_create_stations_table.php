<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stations', function(Blueprint $table) {
			$table->increments('id');
			$table->string('status');
			$table->string('station_name');
			$table->string('type');
			$table->string('source');
			$table->text('description');
			$table->integer('branch_id');
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
		Schema::drop('stations');
	}

}
