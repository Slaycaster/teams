<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomAssignOvertimesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_assign_overtimes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('active_after');
			$table->integer('Allowed_number_of_hours');
			$table->string('name');
			$table->date('range_from');
			$table->date('range_to');
			$table->integer('employee_id');
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
		Schema::drop('custom_assign_overtimes');
	}

}
