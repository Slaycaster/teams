<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeaveCreditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('LeaveCredits', function(Blueprint $table) {
			$table->increments('id');
			$table->string('employee_id');
			$table->float('sick_leave');
			$table->float('vacation_leave');
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
		Schema::drop('LeaveCredits');
	}

}
