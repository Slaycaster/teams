<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeavesummariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leavesummaries', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_id');
			$table->date('start_date');
			$table->date('end_date');
			$table->string('request_type');
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
		Schema::drop('leavesummaries');
	}

}
