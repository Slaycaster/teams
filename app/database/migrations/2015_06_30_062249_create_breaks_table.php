<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBreaksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('breaks', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('schedule_id');
			$table->time('break_in');
			$table->time('break_out');
			$table->string('day');
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
		Schema::drop('breaks');
	}

}
